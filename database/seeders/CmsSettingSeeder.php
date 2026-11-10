<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class CmsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identitas Instansi & Sekolah
            [
                'key' => 'school_name',
                'value' => 'SMK Negeri 1 Kabupaten Tangerang',
                'group' => 'identity',
                'type' => 'text',
                'label' => 'Nama Sekolah / Institusi',
            ],
            [
                'key' => 'school_npsn',
                'value' => '20607890',
                'group' => 'identity',
                'type' => 'text',
                'label' => 'NPSN',
            ],
            [
                'key' => 'school_motto',
                'value' => 'Tangerang Gemilang: Religius, Cerdas, Mandiri, dan Berkeunggulan Teknologi',
                'group' => 'identity',
                'type' => 'text',
                'label' => 'Motto Sekolah',
            ],
            [
                'key' => 'school_logo',
                'value' => 'cms/logos/logo-tangerangkab.png',
                'group' => 'identity',
                'type' => 'image',
                'label' => 'Logo Sekolah',
            ],
            [
                'key' => 'diskominfo_logo',
                'value' => 'cms/logos/logo-diskominfo.png',
                'group' => 'identity',
                'type' => 'image',
                'label' => 'Logo Diskominfo Kab. Tangerang',
            ],

            // Sambutan Kepala Sekolah
            [
                'key' => 'headmaster_name',
                'value' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'group' => 'headmaster',
                'type' => 'text',
                'label' => 'Nama Kepala Sekolah',
            ],
            [
                'key' => 'headmaster_nip',
                'value' => '19740512 199803 1 002',
                'group' => 'headmaster',
                'type' => 'text',
                'label' => 'NIP Kepala Sekolah',
            ],
            [
                'key' => 'headmaster_greeting',
                'value' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Sistem Informasi & Pendataan Sekolah Terpadu. Didukung penuh oleh Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tangerang, portal ini merupakan wujud komitmen kami dalam mewujudkan keterbukaan informasi publik, akuntabilitas data pendidikan, serta layanan digital terintegrasi untuk masyarakat.',
                'group' => 'headmaster',
                'type' => 'textarea',
                'label' => 'Teks Sambutan Kepala Sekolah',
            ],
            [
                'key' => 'headmaster_photo',
                'value' => 'cms/headmaster/kepala_sekolah.jpg',
                'group' => 'headmaster',
                'type' => 'image',
                'label' => 'Foto Kepala Sekolah',
            ],

            // Visi dan Misi
            [
                'key' => 'vision',
                'value' => 'Menjadi institusi pendidikan kejuruan terdepan di Provinsi Banten yang menghasilkan insan berkarakter mulia, adaptif terhadap inovasi kecerdasan buatan & teknologi informasi, serta siap bersaing di kancah industri nasional maupun internasional.',
                'group' => 'academic',
                'type' => 'textarea',
                'label' => 'Visi Sekolah',
            ],
            [
                'key' => 'mission',
                'value' => "1. Menanamkan nilai-nilai keimanan, ketaqwaan, dan integritas etika profesional.\n2. Melaksanakan pembelajaran berbasis industri dan teknologi terapan terkini.\n3. Membangun kemitraan strategis dengan Diskominfo, instansi pemerintah, dan dunia industri.\n4. Mengembangkan potensi bakat, kepemimpinan, dan kewirausahaan peserta didik.",
                'group' => 'academic',
                'type' => 'textarea',
                'label' => 'Misi Sekolah',
            ],

            // Kontak & Lokasi
            [
                'key' => 'school_address',
                'value' => 'Kawasan Pusat Pemerintahan Kabupaten Tangerang, Jl. K.H. Syekh Nawawi No. 1, Sukamulya, Kec. Tigaraksa, Kabupaten Tangerang, Banten 15720',
                'group' => 'contact',
                'type' => 'textarea',
                'label' => 'Alamat Lengkap',
            ],
            [
                'key' => 'school_phone',
                'value' => '(021) 599-8800 / 0811-1920-800',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Telepon / WhatsApp',
            ],
            [
                'key' => 'school_email',
                'value' => 'diskominfo@tangerangkab.go.id',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Email Resmi',
            ],
            [
                'key' => 'maps_embed_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.196377042502!2d106.4916!3d-6.2378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42079093b58607%3A0x6bba84b9ffcf1!2sPusat%20Pemerintahan%20Kabupaten%20Tangerang!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
                'group' => 'contact',
                'type' => 'url',
                'label' => 'URL Google Maps Embed',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

