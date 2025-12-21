<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\PageStatus;
use App\Enums\ActiveStatus;
use App\Enums\FeatureStatus;

class WebsiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a staff member to assign as creator
        $staff = Staff::first();
        $creatorId = $staff ? $staff->id : null;

        // ==========================================
        // 1. About Us Page
        // ==========================================
        $aboutPage = Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Veritas University',
                'meta_title' => 'About Us - Veritas University',
                'meta_description' => 'Learn about the history, mission, and vision of Veritas University.',
                'is_active' => ActiveStatus::ACTIVE->value,
                'status' => PageStatus::PUBLISHED->value,
                'is_featured' => FeatureStatus::FEATURED->value,
                'published_at' => now(),
                'created_by' => $creatorId,
                'approved_by' => $creatorId,
            ]
        );

        // Clear existing blocks to avoid duplicates if re-seeded without migration refresh
        DB::table('website_content_blocks')->where('page_id', $aboutPage->id)->delete();

        // Block 1: AboutHero (First Section)
        DB::table('website_content_blocks')->insert([
            'page_id' => $aboutPage->id,
            'type' => 'template',
            'identifier' => 'about-page-first-section',
            'content' => json_encode([
                'heading1' => 'Welcome to Veritas University',
                'content1' => '<p>Veritas University Abuja (VUNA) is the Catholic University of Nigeria, founded by the Catholic Bishops Conference of Nigeria to provide high-quality tertiary education according to the tradition of the Catholic Church.</p>',
                'content2' => '<p>We are committed to forming students who are not only intellectually capable but also morally sound, preparing them to become self-reliant and responsible citizens.</p>',
                'imageUrl' => '/assets/images/about-hero.jpg', // Placeholder matches frontend expectation
                'slug' => 'about-page-first-section'
            ]),
            'order' => 1,
            'is_active' => ActiveStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Block 2: AboutOurJourney (Second Section)
        DB::table('website_content_blocks')->insert([
            'page_id' => $aboutPage->id,
            'type' => 'template',
            'identifier' => 'about-page-second-section',
            'content' => json_encode([
                'heading1' => 'Our Journey So Far',
                'imageUrl1' => '/assets/images/journey.jpg',
                'content1' => '<p>Since our establishment in 2007, Veritas University has grown from a small campus to a leading institution in Nigeria.</p>',
                'content2' => '<p>We have expanded our academic programs to include a wide range of undergraduate and postgraduate courses.</p>',
                'content3' => '<p>Our permanent site in Bwari, Abuja, offers a serene environment conducive to learning and research.</p>',
                'content4' => '<p>We continue to partner with international institutions to ensure global standards in education.</p>',
                'content5' => '<p>Looking ahead, we aim to become a world-class university recognized for research and innovation.</p>',
                'slug' => 'about-page-second-section'
            ]),
            'order' => 2,
            'is_active' => ActiveStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Block 3: AboutFoundation (Third Section)
        DB::table('website_content_blocks')->insert([
            'page_id' => $aboutPage->id,
            'type' => 'template',
            'identifier' => 'about-page-third-section',
            'content' => json_encode([
                'heading1' => 'Our Foundation',
                'heading2' => 'Mission',
                'heading3' => 'Vision',
                'heading4' => 'Philosophy',
                'heading5' => 'Core Values',
                'imageUrl1' => '/assets/images/foundation.jpg',
                'content1' => '<p>Our foundation is built on the principles of academic excellence and moral integrity.</p>',
                'content2' => '<p>To provide an integral education that combines academic and professional training with moral and spiritual formation.</p>',
                'content3' => '<p>To be a dynamic and culturally relevant university, providing high-quality research and learning experiences.</p>',
                'content4' => '<p>We believe in the education of the whole person, fostering critical thinking and ethical leadership.</p>',
                'content5' => '<ul><li>Academic Excellence</li><li>Moral Integrity</li><li>Service to Humanity</li><li>Social Justice</li></ul>',
                'slug' => 'about-page-third-section'
            ]),
            'order' => 3,
            'is_active' => ActiveStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ==========================================
        // 2. Admission Requirements Page (Example)
        // ==========================================
        $admissionPage = Page::updateOrCreate(
            ['slug' => 'admission-requirements'],
            [
                'title' => 'Admission Requirements',
                'meta_title' => 'Admission Requirements - Veritas University',
                'meta_description' => 'Check the admission requirements for undergraduate and postgraduate programs.',
                'is_active' => ActiveStatus::ACTIVE->value,
                'status' => PageStatus::PUBLISHED->value,
                'is_featured' => FeatureStatus::STANDARD->value,
                'published_at' => now(),
                'created_by' => $creatorId,
                'approved_by' => $creatorId,
            ]
        );

        // Clear existing blocks
        DB::table('website_content_blocks')->where('page_id', $admissionPage->id)->delete();

        // Block 1: AdmissionIntro
        DB::table('website_content_blocks')->insert([
            'page_id' => $admissionPage->id,
            'type' => 'template',
            'identifier' => 'admission-page-first-section',
            'content' => json_encode([
                'heading1' => 'Admission Requirements',
                'content1' => '<p>We welcome applications from qualified candidates for admission into our various undergraduate and postgraduate programs.</p>',
                'slug' => 'admission-page-first-section'
            ]),
            'order' => 1,
            'is_active' => ActiveStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Block 2: UTME Requirements
        DB::table('website_content_blocks')->insert([
            'page_id' => $admissionPage->id,
            'type' => 'template',
            'identifier' => 'admission-page-second-section',
            'content' => json_encode([
                'heading1' => 'UTME Requirements',
                'content1' => '<p>Candidates must have obtained a minimum of 5 credits in relevant subjects including English and Mathematics in WAEC, NECO, or NABTEB in not more than two sittings.</p>',
                'content2' => '<p>Candidates must also sit for the Unified Tertiary Matriculation Examination (UTME) and meet the minimum cut-off mark.</p>',
                'slug' => 'admission-page-second-section'
            ]),
            'order' => 2,
            'is_active' => ActiveStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
