<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminDataController extends Controller
{
    /**
     * ==========================================
     * 1. TEACHER MANAGEMENT (DATA GURU)
     * ==========================================
     */
    public function teachers(Request $request): View
    {
        $search = $request->query('q');
        $status = $request->query('status');

        $query = Teacher::with('homeroomClass');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('subject_specialty', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $teachers = $query->paginate(15)->withQueryString();

        return view('admin.data.teachers.index', compact('teachers', 'search', 'status'));
    }

    public function storeTeacher(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => 'nullable|string|max:30|unique:teachers,nip',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:25|regex:/^[0-9+\-\s]+$/',
            'subject_specialty' => 'required|string|max:100',
            'education_level' => 'required|string|max:20',
            'status' => 'required|in:PNS,P3K,Honorer,GTT',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('data/teachers', 'public');
        }

        Teacher::create(array_merge($validated, ['photo' => $photoPath, 'is_active' => true]));

        return redirect()->back()->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function destroyTeacher(Teacher $teacher): RedirectResponse
    {
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * ==========================================
     * 2. STUDENT MANAGEMENT (DATA SISWA)
     * ==========================================
     */
    public function students(Request $request): View
    {
        $search = $request->query('q');
        $classId = $request->query('class_id');
        $status = $request->query('status');

        $query = Student::with('schoolClass');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $students = $query->paginate(20)->withQueryString();
        $classes = SchoolClass::where('is_active', true)->get();

        return view('admin.data.students.index', compact('students', 'classes', 'search', 'classId', 'status'));
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => 'nullable|string|max:25|unique:students,nis',
            'nisn' => 'required|string|size:10|unique:students,nisn',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'class_id' => 'required|exists:school_classes,id',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:25',
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('data/students', 'public');
        }

        Student::create(array_merge($validated, ['photo' => $photoPath, 'status' => 'Aktif']));

        return redirect()->back()->with('success', 'Data siswa berhasil didaftarkan.');
    }

    public function destroyStudent(Student $student): RedirectResponse
    {
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * ==========================================
     * 3. CLASSES & MAJORS MANAGEMENT
     * ==========================================
     */
    public function classes(): View
    {
        $classes = SchoolClass::with(['major', 'homeroomTeacher'])->withCount('students')->get();
        $majors = Major::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->get();

        return view('admin.data.classes.index', compact('classes', 'majors', 'teachers'));
    }

    public function storeClass(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade_level' => 'required|integer|between:1,13',
            'major_id' => 'nullable|exists:majors,id',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        SchoolClass::create($validated);
        return redirect()->back()->with('success', 'Rombel/Kelas baru berhasil ditambahkan.');
    }

    /**
     * ==========================================
     * 4. IMPORT & EXPORT (CSV / EXCEL CAPABILITY)
     * ==========================================
     */

    /**
     * Export all students to standard CSV.
     */
    public function exportStudents(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_siswa_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Row
            fputcsv($handle, ['NISN', 'NIS', 'Nama Lengkap', 'Jenis Kelamin', 'Kelas', 'Jurusan', 'Tempat Lahir', 'Tanggal Lahir', 'Status', 'Nama Wali', 'No HP Wali']);

            Student::with(['schoolClass.major'])->chunk(200, function ($students) use ($handle) {
                foreach ($students as $student) {
                    fputcsv($handle, [
                        $student->nisn,
                        $student->nis,
                        $student->name,
                        $student->gender,
                        $student->schoolClass?->name ?? '-',
                        $student->schoolClass?->major?->name ?? '-',
                        $student->birth_place,
                        $student->birth_date?->format('Y-m-d'),
                        $student->status,
                        $student->parent_name,
                        $student->parent_phone,
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Download template for student CSV import.
     */
    public function downloadStudentTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_siswa.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['nisn', 'nis', 'name', 'gender', 'class_name', 'birth_place', 'birth_date', 'parent_name', 'parent_phone']);
            // Sample Row
            fputcsv($handle, ['0051234567', '20251001', 'Ahmad Dani', 'L', 'X RPL 1', 'Tangerang', '2008-04-12', 'Bambang', '081234567890']);
            fputcsv($handle, ['0057654321', '20251002', 'Siti Rahmawati', 'P', 'X RPL 1', 'Tangerang', '2008-09-25', 'Supardi', '081987654321']);
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Import students from uploaded CSV.
     */
    public function importStudents(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        // Skip BOM if present
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        if (! $header || count($header) < 5) {
            fclose($handle);
            return redirect()->back()->withErrors(['file' => 'Format file CSV tidak valid atau kolom header kurang.']);
        }

        // Cache classes map (name => id)
        $classes = SchoolClass::pluck('id', 'name')->toArray();

        $imported = 0;
        $errors = [];
        $rowNum = 1;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;
                if (empty($row[0])) continue; // Skip empty row

                $nisn = trim($row[0]);
                $nis = !empty($row[1]) ? trim($row[1]) : null;
                $name = trim($row[2] ?? '');
                $gender = strtoupper(trim($row[3] ?? 'L'));
                $className = trim($row[4] ?? '');
                $birthPlace = trim($row[5] ?? null);
                $birthDate = !empty($row[6]) ? trim($row[6]) : null;
                $parentName = trim($row[7] ?? null);
                $parentPhone = trim($row[8] ?? null);

                if (empty($name) || strlen($nisn) !== 10) {
                    $errors[] = "Baris {$rowNum}: NISN ({$nisn}) atau nama tidak valid.";
                    continue;
                }

                $classId = $classes[$className] ?? null;

                Student::updateOrCreate(
                    ['nisn' => $nisn],
                    [
                        'nis' => $nis,
                        'name' => $name,
                        'gender' => in_array($gender, ['L', 'P']) ? $gender : 'L',
                        'class_id' => $classId,
                        'birth_place' => $birthPlace,
                        'birth_date' => $birthDate,
                        'parent_name' => $parentName,
                        'parent_phone' => $parentPhone,
                        'status' => 'Aktif',
                    ]
                );

                $imported++;
            }

            DB::commit();
            fclose($handle);

            $message = "Berhasil mengimpor {$imported} data siswa.";
            if (count($errors) > 0) {
                $message .= " Beberapa baris dilewati: " . implode('; ', array_slice($errors, 0, 3));
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            return redirect()->back()->withErrors(['file' => 'Gagal memproses import data: ' . $e->getMessage()]);
        }
    }
}

