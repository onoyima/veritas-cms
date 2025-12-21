<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\ContentBlock;
use App\Models\WebsiteStudentGroup;
use App\Models\WebsiteEvent;
use App\Models\WebsiteResearchGroup;
use App\Models\WebsiteMassSchedule;
use App\Models\WebsiteProgram;
use App\Models\WebsiteCourse;
use App\Models\WebsiteFaq;
use App\Models\WebsiteAZEntry;
use App\Models\WebsitePersonnel;
use App\Models\WebsiteNews;
use App\Enums\PageStatus;
use App\Enums\ActiveStatus;
use App\Enums\FeatureStatus;
use Illuminate\Support\Str;

class FrontendStructureSeeder extends Seeder
{
    private function createRichText(string $text): array
    {
        return [
            'nodeType' => 'document',
            'data' => [],
            'content' => [
                [
                    'nodeType' => 'paragraph',
                    'data' => [],
                    'content' => [
                        [
                            'nodeType' => 'text',
                            'value' => $text,
                            'marks' => [],
                            'data' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function createRichTextList(array $items): array
    {
        $listItems = array_map(function($item) {
            return [
                'nodeType' => 'list-item',
                'data' => [],
                'content' => [
                    [
                        'nodeType' => 'paragraph',
                        'data' => [],
                        'content' => [
                            [
                                'nodeType' => 'text',
                                'value' => $item,
                                'marks' => [],
                                'data' => [],
                            ],
                        ],
                    ],
                ],
            ];
        }, $items);

        return [
            'nodeType' => 'document',
            'data' => [],
            'content' => [
                [
                    'nodeType' => 'unordered-list',
                    'data' => [],
                    'content' => $listItems,
                ],
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Student Groups (Campus Life Dependency)
        $this->seedStudentGroups();

        // 2. Seed Events (Campus Life Dependency)
        $this->seedEvents();

        // 3. Seed Research Groups (Research Page Dependency)
        $this->seedResearchGroups();

        // 4. Seed Mass Schedules (Chaplaincy Page Dependency)
        $this->seedMassSchedules();

        // 5. Seed Programs (Undergraduate/Postgraduate Dependency)
        $this->seedPrograms();

        // 6. Seed FAQs
        $this->seedFaqs();

        // 8. Seed Management Team
        $this->seedManagement();

        // 9. Seed News
        $this->seedNews();

        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'meta_title' => 'Home - Veritas University',
                'meta_description' => 'Welcome to Veritas University',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'home-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Shaping the Future Through Education and Innovation',
                            'content1' => $this->createRichText('Join Veritas University and unlock your potential with our world-class education, modern facilities, and inspiring campus life.'),
                            'list' => [
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491849/Vuna-4625_pnjzzx.jpg',
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491816/sisi-4557_bdzki6.jpg',
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491832/Vuna-2019.jpg-_yftz3a.jpg'
                            ],
                            'stats' => [
                                ['id' => 1, 'value' => 50, 'suffix' => '+', 'label' => 'Academic Programs'],
                                ['id' => 2, 'value' => '10:1', 'suffix' => '', 'label' => 'Student-Faculty Ratio', 'isRatio' => true],
                                ['id' => 3, 'value' => 30000, 'suffix' => '+', 'label' => 'Alumni Worldwide'],
                                ['id' => 4, 'value' => 100, 'suffix' => '+', 'label' => 'Research Publications']
                            ],
                            'quick_links' => [
                                ['id' => '1', 'icon' => '/assets/images/library.svg', 'title' => 'Admissions', 'description' => 'Learn about our admissions process and deadlines.', 'link' => '/admissions', 'linkText' => 'Explore Admissions'],
                                ['id' => '2', 'icon' => '/assets/images/graduate-hat.svg', 'title' => 'Programs', 'description' => 'Explore our undergraduate and postgraduate programs.', 'link' => '/undergraduate', 'linkText' => 'View Programs'],
                                ['id' => '3', 'icon' => '/assets/images/spreadsheet.svg', 'title' => 'Student Portal', 'description' => 'Access academic records, course materials, and more.', 'link' => 'https://admission.veritas.edu.ng/admission', 'linkText' => 'Go to Portal']
                            ]
                        ]
                    ],
                    [
                        'type' => 'discover',
                        'identifier' => 'home-discover',
                        'name' => 'Discover Veritas',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Discover Our Top Programs and Departments',
                            'subheading' => 'From cutting-edge research to hands-on learning, explore the diverse programs and departments that empower our students to excel.',
                            'items' => [
                                [
                                    'id' => '1',
                                    'title' => 'World-class faculty and research opportunities.',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg',
                                    'link' => '/research'
                                ],
                                [
                                    'id' => '2',
                                    'title' => 'State-of-the-art facilities and modern campus.',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492279/MTG-4591_e2a3hv.jpg',
                                    'link' => '/campus-life'
                                ],
                                [
                                    'id' => '3',
                                    'title' => 'Extensive academic scholarship programs',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491835/Vuna-2090.jpg-_iiq5o7.jpg',
                                    'link' => '/undergraduate'
                                ],
                                [
                                    'id' => '4',
                                    'title' => 'Cultural activities, play and student week.',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703536/dance-performance_edcqf4.png',
                                    'link' => '/campus-life'
                                ],
                                [
                                    'id' => '5',
                                    'title' => 'Active sports and student events that foster student development.',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491720/sisi-2442_ta8un6.jpg',
                                    'link' => '/campus-life'
                                ],
                                [
                                    'id' => '6',
                                    'title' => 'Dedicated to supporting the spiritual life of our students, staff, and families.',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703440/chaplaincyHolySeeImg_wzusz8.png',
                                    'link' => '/chaplaincy'
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'home-page-third-section',
                        'name' => 'Research Highlights',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Research Highlights',
                            'content1' => $this->createRichText('Explore our commitment to advancing knowledge through impactful research.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg',
                            'heading2' => '200', 'content2' => $this->createRichText('Peer-Reviewed Papers Published Annually'),
                            'heading3' => '50', 'content3' => $this->createRichText('Ongoing Research Initiatives'),
                            'heading4' => '30', 'content4' => $this->createRichText('Partnerships with Leading Organizations')
                        ]
                    ],
                    [
                        'type' => 'services',
                        'identifier' => 'home-services',
                        'name' => 'Our Services',
                        'order' => 4,
                        'content' => [
                            'items' => [
                                ['id' => '1', 'title' => 'World-class faculty and research opportunities.', 'href' => '/research', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg'],
                                ['id' => '2', 'title' => 'State-of-the-art facilities and modern campus.', 'href' => '/campus-life', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492279/MTG-4591_e2a3hv.jpg'],
                                ['id' => '3', 'title' => 'Extensive academic scholarship programs', 'href' => '/undergraduate', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491835/Vuna-2090.jpg-_iiq5o7.jpg'],
                                ['id' => '4', 'title' => 'Cultural activities, play and student week.', 'href' => '/campus-life', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703536/dance-performance_edcqf4.png'],
                                ['id' => '5', 'title' => 'Active sports and student events that foster student development.', 'href' => '/campus-life', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491720/sisi-2442_ta8un6.jpg'],
                                ['id' => '6', 'title' => 'Dedicated to supporting the spiritual life of our students, staff, and families.', 'href' => '/chaplaincy', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703440/chaplaincyHolySeeImg_wzusz8.png']
                            ]
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'home-stay-updated',
                        'name' => 'Stay Updated',
                        'order' => 5,
                        'content' => [
                            'heading' => 'Stay Updated',
                            'subheading' => 'Latest news and events from Veritas University.'
                        ]
                    ],
                    [
                        'type' => 'admissions',
                        'identifier' => 'home-admissions',
                        'name' => 'Admissions',
                        'order' => 6,
                        'content' => [
                            'heading' => 'Admissions',
                            'subheading' => 'Enrol to our programs',
                            'apply_link' => 'https://admission.veritas.edu.ng/admission',
                            'items' => [
                                ['id' => '1', 'title' => 'Undergraduate', 'href' => '/undergraduate', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491827/Vuna-1971.jpg-_k99bco.jpg'],
                                ['id' => '2', 'title' => 'Postgraduate', 'href' => '/postgraduate', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492279/MTG-4591_e2a3hv.jpg'],
                                ['id' => '3', 'title' => 'IJMB', 'href' => '/undergraduate?degree=IJMB', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491835/Vuna-2275.jpg-_rr2ew9.jpg'],
                                ['id' => '4', 'title' => 'JUPEB', 'href' => '/undergraduate?degree=JUPEB', 'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491830/Vuna-1989.jpg-_pqky9v.jpg']
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'home-page-seventh-section',
                        'name' => 'Veritas at a Glance',
                        'order' => 7,
                        'content' => [
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/video/upload/v1/veritas-intro.mp4',
                            'heading1' => '300',
                            'content1' => $this->createRichText('Undergraduate and Postgraduate students across different Programmes'),
                            'heading2' => '10000',
                            'content2' => $this->createRichText('Alumni worldwide making visible impacts and contributing to global development.'),
                            'heading3' => '20000000',
                            'content3' => $this->createRichText('Grants given to local communities around the institution and beyond.'),
                            'heading4' => '56',
                            'content4' => $this->createRichText('Academic professors lecturing, researching and contributing to community.'),
                            'heading5' => '2002',
                            'content5' => $this->createRichText('Our establishment by an Act of Parliament'),
                            'heading6' => '15',
                            'content6' => $this->createRichText('Research Institutes across several interdisciplinary boundaries')
                        ]
                    ],
                    [
                        'type' => 'map',
                        'identifier' => 'home-map',
                        'name' => 'Interactive Map',
                        'order' => 8,
                        'content' => [
                            'heading' => 'Our Location',
                            'description' => 'Find us on the map.'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'meta_title' => 'About Us - Veritas University',
                'meta_description' => 'Learn about our history and mission',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'About Veritas University',
                            'content1' => $this->createRichText('Veritas University is a dynamic community of learning, founded on the Catholic tradition of academic excellence and moral formation. We are committed to nurturing the next generation of leaders who will transform society through knowledge and integrity.'),
                            'content2' => $this->createRichText('Our campus offers a serene and conducive environment for intellectual pursuit, spiritual growth, and social interaction. We believe in the holistic development of every student.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745603546/abouthero_ixjrwo.webp'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-second-section',
                        'name' => 'Our Journey',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'Our Journey',
                            'content1' => $this->createRichText('Founded in 2002 by the Catholic Bishops Conference of Nigeria, Veritas University has grown from humble beginnings to become a premier institution of higher learning.'),
                            'content2' => $this->createRichText('Licensed by the National Universities Commission in 2007, we have consistently upheld high academic standards.'),
                            'content3' => $this->createRichText('We commenced academic activities in Obehie, Abia State, before moving to our permanent site.'),
                            'content4' => $this->createRichText('Relocated to the permanent campus in Abuja in 2008, expanding our facilities and programs.'),
                            'content5' => $this->createRichText('Today, we continue to grow with new faculties, research centers, and a diverse student body.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492247/MTG-0080_a83egc.jpg'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-third-section',
                        'name' => 'Foundation & History',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Foundation',
                            'content1' => $this->createRichText('Veritas University, Abuja (VUNA) is the Catholic University of Nigeria, established to provide high-quality education balanced with moral and spiritual values.'),
                            'heading2' => 'Mission',
                            'content2' => $this->createRichText('To provide integral education that combines academic excellence with moral and spiritual formation, empowering students to become ethical leaders.'),
                            'heading3' => 'Vision',
                            'content3' => $this->createRichText('To be a top-class university recognized globally for research, teaching, and community service.'),
                            'heading4' => 'Philosophy',
                            'content4' => $this->createRichText('To produce graduates who are theoretically knowledgeable and practically skillful, ready to contribute to national development.'),
                            'heading5' => 'Core Values',
                            'content5' => $this->createRichTextList(['Academic Excellence', 'Moral Integrity', 'Service to Humanity', 'Social Justice'])
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-fourth-section',
                        'name' => 'Management Team',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'University Management',
                            'content1' => $this->createRichText('Meet the dedicated team leading Veritas University towards achieving its strategic goals.'),
                            'content2' => $this->createRichText('Our management team comprises experienced administrators and distinguished academics committed to excellence.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491824/VC_rwpbwj.jpg'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Admissions',
                'slug' => 'admissions',
                'meta_title' => 'Admissions - Veritas University',
                'meta_description' => 'Join us at Veritas University',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'admission-undergraduate-page',
                        'name' => 'Undergraduate Admissions',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Undergraduate Admissions',
                            'content1' => $this->createRichText('Start your academic journey with our diverse undergraduate programs. We offer a wide range of courses designed to prepare you for a successful career.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491827/Vuna-1971.jpg-_k99bco.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491830/Vuna-1989.jpg-_pqky9v.jpg',
                            'heading2' => 'Admission Requirements',
                            'content2' => $this->createRichText('Candidates must possess a minimum of 5 credits in WAEC/NECO/NABTEB including English Language and Mathematics at not more than two sittings.'),
                            'heading3' => 'How to Apply',
                            'content3' => $this->createRichText('Visit our admissions portal to complete your application form online. Upload necessary documents and pay the application fee.'),
                            'link1' => 'https://admission.veritas.edu.ng',
                            'heading4' => 'Tuition & Fees',
                            'content4' => $this->createRichText('Our tuition fees are affordable and competitive. Visit the Fees page for a detailed breakdown.'),
                            'list' => ['Minimum of 5 Credits in WAEC/NECO === UTME Score of 170+ === Birth Certificate === Testimonial']
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-jupeb-page',
                        'name' => 'JUPEB Admissions',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'JUPEB Admissions',
                            'content1' => $this->createRichText('Gain direct entry into 200 level with our JUPEB program. It is an intensive 9-month program designed to prepare you for university education.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491830/Vuna-1989.jpg-_pqky9v.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491827/Vuna-1971.jpg-_k99bco.jpg',
                            'heading2' => 'Admission Requirements',
                            'content2' => $this->createRichText('Candidates must possess a minimum of 5 credits in O-Level subjects relevant to their desired course of study.'),
                            'heading3' => 'How to Apply',
                            'content3' => $this->createRichText('Click the button below to start your JUPEB application.'),
                            'link1' => 'https://admission.veritas.edu.ng/jupeb',
                            'heading4' => 'Program Duration',
                            'content4' => $this->createRichText('The program runs for one academic session (approximately 9 months).'),
                            'list' => ['5 Credits in O-Level === Birth Certificate === Testimonial === Passport Photograph']
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-ijamb-page',
                        'name' => 'IJMB Admissions',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'IJMB Admissions',
                            'content1' => $this->createRichText('The Interim Joint Matriculation Board (IJMB) program offers another pathway to university admission without JAMB.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491835/Vuna-2275.jpg-_rr2ew9.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491832/Vuna-2019.jpg-_yftz3a.jpg',
                            'heading2' => 'Admission Requirements',
                            'content2' => $this->createRichText('Candidates must have 5 O-Level credits. IJMB certificate is accepted in most Nigerian universities for Direct Entry.'),
                            'heading3' => 'How to Apply',
                            'content3' => $this->createRichText('Apply online through our portal.'),
                            'link1' => 'https://admission.veritas.edu.ng/ijmb',
                            'heading4' => 'Benefits',
                            'content4' => $this->createRichText('IJMB results do not expire and guarantee admission into 200 level.'),
                            'list' => ['5 Credits in O-Level === Birth Certificate === Testimonial === Passport Photograph']
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-sandwich-page',
                        'name' => 'Sandwich Admissions',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'Sandwich Admissions',
                            'content1' => $this->createRichText('Our Sandwich program is designed for working professionals who want to further their education while maintaining their careers.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491816/sisi-4557_bdzki6.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491849/Vuna-4625_pnjzzx.jpg',
                            'heading2' => 'Admission Requirements',
                            'content2' => $this->createRichText('Applicants must possess relevant NCE or Diploma certificates in addition to O-Level credits.'),
                            'heading3' => 'How to Apply',
                            'content3' => $this->createRichText('Pick up a form at the university or apply online.'),
                            'link1' => 'https://admission.veritas.edu.ng/sandwich',
                            'heading4' => 'Schedule',
                            'content4' => $this->createRichText('Lectures are held during holidays and weekends to accommodate work schedules.'),
                            'list' => ['NCE/Diploma Certificate === 5 Credits in O-Level === Birth Certificate === Employment Letter (Optional)']
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-postgraduate-page',
                        'name' => 'Postgraduate Admissions',
                        'order' => 5,
                        'content' => [
                            'heading1' => 'Postgraduate Admissions',
                            'content1' => $this->createRichText('Advance your career with our postgraduate degrees. We offer PGD, Masters, and PhD programs across various disciplines.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492279/MTG-4591_e2a3hv.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg',
                            'heading2' => 'Admission Requirements',
                            'content2' => $this->createRichText('A good first degree from a recognized university. For PhD, a Masters degree is required.'),
                            'heading3' => 'How to Apply',
                            'content3' => $this->createRichText('Complete the online application form and submit your transcripts.'),
                            'link1' => 'https://admission.veritas.edu.ng/pg',
                            'heading4' => 'Research Areas',
                            'content4' => $this->createRichText('Our postgraduate school supports cutting-edge research in Humanities, Sciences, and Social Sciences.'),
                            'list' => ['NYSC Discharge Certificate === University Degree Certificate === Transcript === 3 Reference Letters']
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Campus Life',
                'slug' => 'campus-life',
                'meta_title' => 'Campus Life - Veritas University',
                'meta_description' => 'Experience life at Veritas',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'campus-life-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Campus Life === at Veritas',
                            'content1' => $this->createRichText('Veritas University offers a vibrant campus life experience, fostering community, personal growth, and academic excellence.'),
                            'list' => [
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745793034/collaboration_lalqvy.png === https://res.cloudinary.com/dbhjueg2l/image/upload/v1745793273/people-hanging-out_fwh4zg.png',
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703545/soccer-game_jj5lta.png === https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703530/cultural-day_rnxldp.png',
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745795747/male-students_puozny.png === https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703525/basketball-game_slfqp0.png',
                                'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703536/dance-performance_edcqf4.png === https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703533/man-with-yoga-mat_v2lup6.png'
                            ]
                        ]
                    ],
                    [
                        'type' => 'stats',
                        'identifier' => 'campus-life-stats',
                        'name' => 'Student Statistics',
                        'order' => 2,
                        'content' => [
                            'stats' => [
                                ['id' => 1, 'value' => 30000, 'suffix' => ' +', 'label' => 'Alumni Worldwide'],
                                ['id' => 2, 'value' => '10', 'suffix' => '+', 'label' => 'Organized student groups'],
                                ['id' => 3, 'value' => 4000, 'suffix' => ' +', 'label' => 'Students living on campus']
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'campus-life-page-second-section',
                        'name' => 'Student Bodies',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Student Bodies',
                            'items' => [
                                [
                                    'heading1' => 'SRA === Students Representative Assembly',
                                    'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745818585/protestors_mxeted.png',
                                    'content1' => $this->createRichText("A Student Representative Assembly (SRA) in a Catholic university context serves as the official voice of the student body, representing student interests while operating within the university's Catholic mission and values. The SRA acts as the primary governing body for student affairs, creating a structured channel for student participation in university governance. In Catholic universities, the SRA helps ensure student perspectives are integrated into decision-making while respecting the institution's religious identity.")
                                ],
                                [
                                    'heading1' => 'NFCS === Nigerian Federation of Catholic Students',
                                    'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745817925/cathedral_baubm0.png',
                                    'content1' => $this->createRichText("Student Representative Assembly (SRA) in a Catholic university context serves as the official voice of the student body, representing student interests while operating within the university's Catholic mission and values. Here's a comprehensive overview of student participation in university governance. In Catholic universities, the SRA helps ensure student perspectives are integrated into decision-making while respecting the institution's religious identity.")
                                ],
                                [
                                    'heading1' => 'VERITAS SPORTS === Veritas University Sports Center',
                                    'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703553/track_qstmjv.png',
                                    'content1' => $this->createRichText("A Student Representative Assembly (SRA) in a Catholic university context serves as the official voice of the student body, representing student interests while operating within the university's Catholic mission and as the primary governing body for student affairs, creating a structured channel for student participation in university governance. In Catholic universities, the SRA helps ensure student perspectives are integrated into decision-making while respecting the institution's religious identity.")
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'campus-life-student-groups',
                        'name' => 'Join a Group',
                        'order' => 4,
                        'content' => [
                            'heading' => 'Join a Student Group',
                            'subheading' => 'Explore our diverse range of student clubs and organizations.'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'campus-life-events',
                        'name' => 'Recent Events',
                        'order' => 5,
                        'content' => [
                            'heading' => 'Recent Events',
                            'subheading' => 'Stay updated with the latest happenings on campus.'
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Chaplaincy',
                'slug' => 'chaplaincy',
                'meta_title' => 'Chaplaincy - Veritas University',
                'meta_description' => 'Spiritual Life',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Chaplaincy',
                            'content1' => $this->createRichText('Nurturing the spiritual life of the Veritas community.')
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy-page-second-section',
                        'name' => 'Our Focus',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'Our Spiritual Focus',
                            'content1' => $this->createRichText('We focus on the holistic formation of our students through prayer, sacraments, and service.')
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy-page-third-section',
                        'name' => 'The Holy See',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'The Holy See',
                            'content1' => $this->createRichText('Guided by the teachings of the Catholic Church and the Holy Father.')
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy_mass',
                        'name' => 'Mass Schedules',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'Mass Schedules',
                            'content1' => $this->createRichTextList([
                                'Daily Mass: 6:30 AM, 12:00 PM',
                                'Sunday Mass: 7:00 AM, 9:00 AM'
                            ])
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Tuition & Fees',
                'slug' => 'fees',
                'meta_title' => 'Tuition & Fees - Veritas University',
                'meta_description' => 'Fee structure and payment info',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'fees-page-first-section',
                        'name' => 'Fees Hero',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Tuition & Fees',
                            'content1' => $this->createRichText('We are committed to providing affordable quality education. Find detailed information about tuition, accommodation, and other fees here.')
                        ]
                    ],
                    [
                        'type' => 'course_fees',
                        'identifier' => 'fees-course-fees',
                        'name' => 'Course Fees List',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Course Fees',
                            'items' => [
                                ['program' => 'Accounting', 'amount' => '450,000', 'faculty' => 'Social Sciences'],
                                ['program' => 'Computer Science', 'amount' => '550,000', 'faculty' => 'Natural Sciences'],
                                ['program' => 'Law', 'amount' => '800,000', 'faculty' => 'Law'],
                                ['program' => 'Medicine & Surgery', 'amount' => '1,500,000', 'faculty' => 'Medical Sciences'],
                            ]
                        ]
                    ],
                    [
                        'type' => 'accommodation_fees',
                        'identifier' => 'fees-accommodation-fees',
                        'name' => 'Accommodation Fees',
                        'order' => 3,
                        'content' => [
                            'heading' => 'Accommodation',
                            'items' => [
                                ['type' => '4 Bed Space', 'amount' => '100,000'],
                                ['type' => '2 Bed Space', 'amount' => '200,000'],
                                ['type' => 'Self Contain', 'amount' => '400,000'],
                            ]
                        ]
                    ],
                    [
                        'type' => 'school_accounts',
                        'identifier' => 'fees-school-accounts',
                        'name' => 'Bank Accounts',
                        'order' => 4,
                        'content' => [
                            'heading' => 'Payment Accounts',
                            'items' => [
                                ['bank' => 'GTBank', 'account_number' => '0123456789', 'account_name' => 'Veritas University Tuition'],
                                ['bank' => 'Zenith Bank', 'account_number' => '9876543210', 'account_name' => 'Veritas University Other Charges'],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Research',
                'slug' => 'research',
                'meta_title' => 'Research - Veritas University',
                'meta_description' => 'Research and Innovation',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'research-page-first-section',
                        'name' => 'Research Hero',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Research at Veritas',
                            'content1' => $this->createRichText('We are a research-intensive university committed to solving local and global challenges through innovative research.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745603546/abouthero_ixjrwo.webp'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'research-page-stats',
                        'name' => 'Research Stats',
                        'order' => 2,
                        'content' => [
                            'stats' => [
                                ['value' => '15', 'suffix' => ' Institutes', 'label' => 'Cross interdisciplinary boundaries'],
                                ['value' => '200', 'suffix' => '+', 'label' => 'Published article and manuscript'],
                                ['value' => '2.2', 'prefix' => '₦', 'suffix' => ' Billion', 'label' => 'Sponsored research budget'],
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'research-groups-list',
                        'name' => 'Research Groups',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Our Research Focus and Themes',
                            'content1' => $this->createRichText('Explore our specialized research teams.'),
                            'items' => [
                                [
                                    'title' => 'SLAC National Accelerator Laboratory',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703411/cpu_dggfra.png',
                                    'link' => 'slac'
                                ],
                                [
                                    'title' => 'Neuroscience',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703416/jellyfish_kfpoww.png',
                                    'link' => 'neuroscience'
                                ],
                                [
                                    'title' => 'Mechanical labs and research',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703410/engine_j8lojv.png',
                                    'link' => 'mechanical-labs'
                                ],
                                [
                                    'title' => 'Biomedical Sciences',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703409/mouse_s4txno.png',
                                    'link' => 'biomedical-sciences'
                                ],
                                [
                                    'title' => 'SLAC National Accelerator Laboratory',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703408/architectural-plan_icqwcq.png',
                                    'link' => 'slac'
                                ],
                                [
                                    'title' => 'Psychology',
                                    'image' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745602146/painted-face_gz9egr.png',
                                    'link' => 'psychology'
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'research-page-third-section',
                        'name' => 'Research Publications',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'Recent Publications',
                            'items' => [
                                [
                                    'img' => '/assets/images/publication-a.png',
                                    'title' => 'Research Articles, Behavioral/Cognitive',
                                    'description' => 'Learning modulates early encephalographic responses to distracting stimuli: a combined SSVEP and ERP study',
                                    'reference' => 'Journal of Neuroscience 4 April 2025, e1973242025; https://doi.org/10.1523/JNEUROSCI.1973-24.2025',
                                    'subtext' => 'Research Articles, Behavioral/Cognitive'
                                ],
                                [
                                    'img' => '/assets/images/publication-b.png',
                                    'title' => 'Research Articles, Behavioral/Cognitive',
                                    'description' => 'Learning modulates early encephalographic responses to distracting stimuli: a combined SSVEP and ERP study',
                                    'reference' => 'Journal of Neuroscience 4 April 2025, e1973242025; https://doi.org/10.1523/JNEUROSCI.1973-24.2025',
                                    'subtext' => 'Research Articles, Behavioral/Cognitive'
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'research-sdgs',
                        'name' => 'SDGs',
                        'order' => 5,
                        'content' => [
                            'heading1' => 'Sustainable Development Goals',
                            'items' => [
                                ['label' => 'SDG 1 - No Poverty', 'color' => '#000', 'bgColor' => '#BAFFE5'],
                                ['label' => 'SDG 2 - Zero Hunger', 'color' => '#fff', 'bgColor' => '#095D3F'],
                                ['label' => 'SDG 3 - Good Health and Wellbeing', 'color' => '#fff', 'bgColor' => '#466DEE'],
                                ['label' => 'SDG 4 - Quality Education', 'color' => '#fff', 'bgColor' => '#C5192D'],
                                ['label' => 'SDG 5 - Gender Equality', 'color' => '#fff', 'bgColor' => '#FF3A21'],
                                ['label' => 'SDG 6 - Clean Water and Sanitation', 'color' => '#fff', 'bgColor' => '#26BDE2'],
                                ['label' => 'SDG 7 - Affordable and Clean Energy', 'color' => '#000', 'bgColor' => '#FCC30B'],
                                ['label' => 'SDG 8 - Decent work and Economic Growth', 'color' => '#fff', 'bgColor' => '#A21942'],
                                ['label' => 'SDG 9 - Industry, Innovation and Infrastructure', 'color' => '#fff', 'bgColor' => '#FD6925'],
                                ['label' => 'SDG 10 - Reduced Inequalities', 'color' => '#fff', 'bgColor' => '#DD1367'],
                            ]
                        ]
                    ]

                ]
            ],
            [
                'title' => 'News & Events',
                'slug' => 'news-and-events',
                'meta_title' => 'News & Events - Veritas University',
                'meta_description' => 'Latest updates',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'news-page-hero',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'News & Events',
                            'content1' => $this->createRichText('Stay updated with the latest happenings at Veritas University.')
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'news-highlighted-events',
                        'name' => 'Highlighted Events',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Highlighted Events',
                            'subheading' => 'Don\'t miss these upcoming events.'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'news-listing',
                        'name' => 'All News & Events',
                        'order' => 3,
                        'content' => [
                            'heading' => 'Latest News',
                            'subheading' => 'Browse all news and events.'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Undergraduate',
                'slug' => 'undergraduate',
                'meta_title' => 'Undergraduate Programs - Veritas University',
                'meta_description' => 'Explore our undergraduate programs',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'undergraduate-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Undergraduate School',
                            'content1' => $this->createRichText('Join our vibrant community of learners and leaders. Discover programs that ignite your passion and prepare you for the future.'),
                            'imageUrl1' => '/assets/images/undergraduate/hero-bg-1.jpg',
                            'imageUrl2' => '/assets/images/undergraduate/hero-bg-2.jpg',
                            'list' => [
                                'Graduates === 5000',
                                'Faculties === 6',
                                'Departments === 30',
                                'Students === 10000'
                            ]
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'undergraduate-programs-list',
                        'name' => 'Programs List',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Explore Our Undergraduate Programs',
                            'subheading' => 'Find the perfect program for you.'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'undergraduate-page-third-section',
                        'name' => 'Why Choose Veritas?',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Why Choose Veritas?',
                            'content1' => $this->createRichText('Experienced Faculty, Practical Learning, and Career Growth.')
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Postgraduate',
                'slug' => 'postgraduate',
                'meta_title' => 'Postgraduate Programs - Veritas University',
                'meta_description' => 'Explore our postgraduate programs',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'postgraduate-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Postgraduate School',
                            'content1' => $this->createRichText('Advance your career with our world-class postgraduate programs. Engage in research that matters.'),
                            'imageUrl1' => '/assets/images/postgraduate/hero-bg.jpg'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'postgraduate-programs-list',
                        'name' => 'Programs List',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Explore Postgraduate Programs',
                            'subheading' => 'Masters, PhD, and PGD programs.'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'A-Z Index',
                'slug' => 'a-z',
                'meta_title' => 'A-Z Index - Veritas University',
                'meta_description' => 'Comprehensive directory',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'a-z-page-hero',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'A–Z Index of Veritas University',
                            'content1' => $this->createRichText('Use this comprehensive directory to quickly access all departments, services, programs, and university resources. Browse alphabetically or search to find what you’re looking for.')
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'a-z-listing',
                        'name' => 'A-Z List',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Directory',
                            'subheading' => 'Browse by alphabet.',
                            'az_list' => [
                                ['alphabet' => 'A', 'routes' => [
                                    ['name' => 'About Us', 'link' => '/about', 'description' => 'Get to know Veritas University, its mission, and history.'],
                                    ['name' => 'Admissions', 'link' => '/admissions', 'description' => 'Start your journey—review admission requirements and how to apply.']
                                ]],
                                ['alphabet' => 'B', 'routes' => []],
                                ['alphabet' => 'C', 'routes' => [
                                    ['name' => 'Chaplaincy at Veritas', 'link' => '/chaplaincy', 'description' => 'Learn about our spiritual support and chaplaincy services.'],
                                    ['name' => 'Campus Life', 'link' => '/campus-life', 'description' => 'Experience student life, clubs, facilities, and more at Veritas.']
                                ]],
                                ['alphabet' => 'D', 'routes' => []],
                                ['alphabet' => 'E', 'routes' => []],
                                ['alphabet' => 'F', 'routes' => [
                                    ['name' => 'FAQ', 'link' => '/faq', 'description' => 'Find answers to commonly asked questions about Veritas University.']
                                ]],
                                ['alphabet' => 'G', 'routes' => []],
                                ['alphabet' => 'H', 'routes' => [
                                    ['name' => 'Home', 'link' => '/', 'description' => 'Welcome to Veritas University – your gateway to academic excellence.']
                                ]],
                                ['alphabet' => 'I', 'routes' => []],
                                ['alphabet' => 'J', 'routes' => []],
                                ['alphabet' => 'K', 'routes' => []],
                                ['alphabet' => 'L', 'routes' => []],
                                ['alphabet' => 'M', 'routes' => []],
                                ['alphabet' => 'N', 'routes' => [
                                    ['name' => 'News and Events', 'link' => '/news-and-events', 'description' => 'Stay updated with the latest happenings and announcements.']
                                ]],
                                ['alphabet' => 'O', 'routes' => []],
                                ['alphabet' => 'P', 'routes' => [
                                    ['name' => 'Postgraduate Programs', 'link' => '/postgraduate', 'description' => 'Advance your education with our specialized postgraduate offerings.']
                                ]],
                                ['alphabet' => 'Q', 'routes' => []],
                                ['alphabet' => 'R', 'routes' => [
                                    ['name' => 'Research', 'link' => '/research', 'description' => 'Discover our innovative research initiatives and academic contributions.']
                                ]],
                                ['alphabet' => 'S', 'routes' => []],
                                ['alphabet' => 'T', 'routes' => [
                                    ['name' => 'Fees', 'link' => '/fees', 'description' => 'Explore tuition fees, payment plans, and financial aid options.']
                                ]],
                                ['alphabet' => 'U', 'routes' => [
                                    ['name' => 'Undergraduate Programs', 'link' => '/undergraduate', 'description' => 'Browse our diverse undergraduate programs across various disciplines.'],
                                    ['name' => 'University Management', 'link' => '/university-management', 'description' => 'Meet the leadership team guiding Veritas University.']
                                ]],
                                ['alphabet' => 'V', 'routes' => []],
                                ['alphabet' => 'W', 'routes' => []],
                                ['alphabet' => 'X', 'routes' => []],
                                ['alphabet' => 'Y', 'routes' => []],
                                ['alphabet' => 'Z', 'routes' => []],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'meta_title' => 'FAQ - Veritas University',
                'meta_description' => 'Frequently Asked Questions',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'faq-page-hero',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'Frequently Asked Questions',
                            'content1' => $this->createRichText('Find answers to the most common questions about admissions, academics, campus life, and student services. Still need help? Our team is here to support you.')
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'faq-listing',
                        'name' => 'FAQ List',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Questions',
                            'subheading' => 'Search or browse questions.'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'University Management',
                'slug' => 'university-management',
                'meta_title' => 'University Management - Veritas University',
                'meta_description' => 'Meet our leaders',
                'blocks' => [
                    [
                        'type' => 'template',
                        'identifier' => 'university-management-page-first-section',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'University Management',
                            'content1' => $this->createRichText('Meet the visionary leaders guiding Veritas University towards excellence.'),
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491845/Vuna-2495_anpcht.jpg',
                            'imageUrl2' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491782/sisi-2689_xk5trj.jpg'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'management-leadership',
                        'name' => 'Leadership Team',
                        'order' => 2,
                        'content' => [
                            'heading' => 'Principal Officers',
                            'subheading' => 'Key decision makers.'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'management-other',
                        'name' => 'Other Management',
                        'order' => 3,
                        'content' => [
                            'heading' => 'Management Team',
                            'subheading' => 'Heads of units and departments.'
                        ]
                    ]
                ]
            ],
        ];

        foreach ($pages as $pageData) {
            $page = Page::firstOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title' => $pageData['title'],
                    'meta_title' => $pageData['meta_title'],
                    'meta_description' => $pageData['meta_description'],
                    'status' => PageStatus::PUBLISHED,
                    'is_active' => ActiveStatus::ACTIVE,
                    'is_featured' => FeatureStatus::STANDARD,
                    'published_at' => now(),
                ]
            );

            // Sync blocks
            foreach ($pageData['blocks'] as $blockData) {
                ContentBlock::updateOrCreate(
                    [
                        'page_id' => $page->id,
                        'identifier' => $blockData['identifier']
                    ],
                    [
                        'type' => $blockData['type'],
                        'order' => $blockData['order'],
                        'is_active' => ActiveStatus::ACTIVE,
                        'content' => $blockData['content'] ?? [
                            'heading' => $blockData['name'],
                            'subheading' => 'Placeholder subheading for ' . $blockData['name'],
                            'content' => 'Lorem ipsum dolor sit amet.',
                        ]
                    ]
                );

        }
    }
}

    private function seedStudentGroups(): void
    {
        $groups = [
            [
                'title' => 'Debate Club',
                'description' => 'The Veritas Debate Club fosters critical thinking, public speaking, and argumentation skills. Members participate in inter-university competitions and host local debates on current affairs.',
                'member_count' => '50+',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703532/debate-club_shkywb.png'
            ],
            [
                'title' => 'Dance Group',
                'description' => 'Our Dance Group explores various dance styles from traditional African dances to contemporary and hip-hop. We perform at university events and cultural festivals.',
                'member_count' => '30+',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703528/dance-club_vycyzd.png'
            ],
            [
                'title' => 'Drama Group',
                'description' => 'The Drama Group brings stories to life on stage. From Shakespearean classics to modern plays, we provide opportunities for acting, directing, and stage management.',
                'member_count' => '40+',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703530/drama-club_hjtxgq.png'
            ],
            [
                'title' => 'Musical Group',
                'description' => 'The Musical Group comprises the university choir and instrumentalists. We lead music at liturgical celebrations and perform at concerts and social events.',
                'member_count' => '60+',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703534/music-club_poxetf.png'
            ],
        ];

        foreach ($groups as $group) {
            WebsiteStudentGroup::updateOrCreate(
                ['title' => $group['title']],
                [
                    'slug' => Str::slug($group['title']),
                    'description' => $group['description'],
                    'member_count' => $group['member_count'],
                    'image_url' => $group['image_url'],
                    'is_active' => ActiveStatus::ACTIVE,
                ]
            );
        }
    }

    private function seedEvents(): void
    {
        $events = [
            [
                'heading' => 'Inter-Faculty Football Tournament',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703542/soccer-game-2_mzg5lq.png',
                'event_type' => 'Sports'
            ],
            [
                'heading' => 'Student Week Opening Ceremony',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703549/student-of-the-week_syvj3u.png',
                'event_type' => 'Social'
            ],
            [
                'heading' => 'Cultural Day Celebration',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703536/dance-performance_edcqf4.png',
                'event_type' => 'Cultural'
            ],
            [
                'heading' => 'Veritas Sports Festival',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703551/sports_f6zd8p.png',
                'event_type' => 'Sports'
            ],
            [
                'heading' => 'Novelty Match: Staff vs Students',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703545/soccer-game_jj5lta.png',
                'event_type' => 'Sports'
            ],
            [
                'heading' => 'Drama Night',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703530/cultural-day_rnxldp.png',
                'event_type' => 'Arts'
            ],
        ];

        foreach ($events as $event) {
            WebsiteEvent::updateOrCreate(
                ['heading' => $event['heading']],
                [
                    'slug' => Str::slug($event['heading']),
                    'image_url' => $event['image_url'],
                    'event_type' => $event['event_type'],
                    'start_date_and_time' => now()->subDays(rand(1, 30)),
                    'end_date_and_time' => now()->subDays(rand(1, 30))->addHours(2),
                    'location' => 'Veritas Campus',
                    'is_active' => ActiveStatus::ACTIVE,
                ]
            );
        }
    }

    private function seedResearchGroups(): void
    {
        $groups = [
            [
                'title' => 'SLAC National Accelerator Laboratory',
                'slug' => 'slac',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703411/cpu_dggfra.png',
                'spotlight' => [
                    'content' => [
                        [
                            'nodeType' => 'paragraph',
                            'data' => [],
                            'content' => [
                                [
                                    'nodeType' => 'text',
                                    'value' => 'SLAC is a U.S. Department of Energy national laboratory operated by Stanford, conducting research in chemistry, materials and energy sciences, bioscience, fusion energy science, high-energy physics, cosmology and other fields.',
                                    'marks' => [],
                                    'data' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Neuroscience',
                'slug' => 'neuroscience',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703416/jellyfish_kfpoww.png',
                'spotlight' => [
                    'content' => [
                        [
                            'nodeType' => 'paragraph',
                            'data' => [],
                            'content' => [
                                [
                                    'nodeType' => 'text',
                                    'value' => 'Neuroscience research at Veritas explores the complexities of the brain and nervous system, advancing understanding of cognitive processes and neurological disorders.',
                                    'marks' => [],
                                    'data' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Mechanical labs and research',
                'slug' => 'mechanical-labs',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703410/engine_j8lojv.png',
                'spotlight' => [
                    'content' => [
                        [
                            'nodeType' => 'paragraph',
                            'data' => [],
                            'content' => [
                                [
                                    'nodeType' => 'text',
                                    'value' => 'Our mechanical labs are equipped with state-of-the-art technology to support research in robotics, thermodynamics, and materials engineering.',
                                    'marks' => [],
                                    'data' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Biomedical Sciences',
                'slug' => 'biomedical-sciences',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745703409/mouse_s4txno.png',
                'spotlight' => [
                    'content' => [
                        [
                            'nodeType' => 'paragraph',
                            'data' => [],
                            'content' => [
                                [
                                    'nodeType' => 'text',
                                    'value' => 'Biomedical research focuses on developing new treatments and diagnostic tools to improve human health and combat diseases.',
                                    'marks' => [],
                                    'data' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Psychology',
                'slug' => 'psychology',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745602146/painted-face_gz9egr.png',
                'spotlight' => [
                    'content' => [
                        [
                            'nodeType' => 'paragraph',
                            'data' => [],
                            'content' => [
                                [
                                    'nodeType' => 'text',
                                    'value' => 'Our Psychology department conducts cutting-edge research in behavioral science, mental health, and social psychology.',
                                    'marks' => [],
                                    'data' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];

        foreach ($groups as $group) {
            WebsiteResearchGroup::updateOrCreate(
                ['slug' => $group['slug']],
                [
                    'title' => $group['title'],
                    'image_url' => $group['image_url'],
                    'spotlight' => $group['spotlight'],
                    'is_active' => ActiveStatus::ACTIVE,
                ]
            );
        }
    }

    private function seedMassSchedules(): void
    {
        $schedules = [
            [
                'day' => 'Sunday',
                'start_time' => '07:00:00',
                'end_time' => '09:00:00',
                'invitees' => ['Students', 'Staff', 'Public']
            ],
            [
                'day' => 'Monday',
                'start_time' => '06:30:00',
                'end_time' => '07:30:00',
                'invitees' => ['Students', 'Staff']
            ],
            [
                'day' => 'Tuesday',
                'start_time' => '06:30:00',
                'end_time' => '07:30:00',
                'invitees' => ['Students', 'Staff']
            ],
            [
                'day' => 'Wednesday',
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'invitees' => ['Students', 'Staff']
            ],
            [
                'day' => 'Thursday',
                'start_time' => '06:30:00',
                'end_time' => '07:30:00',
                'invitees' => ['Students', 'Staff']
            ],
            [
                'day' => 'Friday',
                'start_time' => '06:30:00',
                'end_time' => '07:30:00',
                'invitees' => ['Students', 'Staff']
            ],
            [
                'day' => 'Saturday',
                'start_time' => '07:00:00',
                'end_time' => '08:00:00',
                'invitees' => ['Students', 'Staff']
            ]
        ];

        foreach ($schedules as $schedule) {
            WebsiteMassSchedule::updateOrCreate(
                ['day' => $schedule['day']],
                [
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'invitees' => $schedule['invitees'],
                    'is_active' => ActiveStatus::ACTIVE
                ]
            );
        }
    }

    private function seedPrograms(): void
    {
        $programs = [
            [
                'title' => 'B.Sc. Computer Science',
                'slug' => 'bsc-computer-science',
                'category' => 'undergraduate',
                'level' => 'Bachelor',
                'degree' => 'B.Sc.',
                'faculty' => 'Faculty of Natural and Applied Sciences',
                'duration' => 4,
                'description' => 'The Computer Science program provides a strong foundation in computing principles, software development, and systems analysis.',
                'course_name' => 'Computer Science'
            ],
            [
                'title' => 'MBBS Medicine and Surgery',
                'slug' => 'mbbs-medicine-and-surgery',
                'category' => 'undergraduate',
                'level' => 'Bachelor',
                'degree' => 'MBBS',
                'faculty' => 'College of Medicine',
                'duration' => 6,
                'description' => 'Our MBBS program trains future physicians with a comprehensive curriculum covering medical sciences and clinical practice.',
                'course_name' => 'Medicine and Surgery'
            ],
            [
                'title' => 'B.Sc. Nursing Science',
                'slug' => 'bsc-nursing-science',
                'category' => 'undergraduate',
                'level' => 'Bachelor',
                'degree' => 'B.Sc.',
                'faculty' => 'Faculty of Health Sciences',
                'duration' => 5,
                'description' => 'The Nursing Science program prepares students for professional nursing practice in various healthcare settings.',
                'course_name' => 'Nursing Science'
            ],
            [
                'title' => 'B.Eng. Computer Engineering',
                'slug' => 'b-eng-computer-engineering',
                'category' => 'undergraduate',
                'level' => 'Bachelor',
                'degree' => 'B.Eng.',
                'faculty' => 'Faculty of Engineering',
                'duration' => 5,
                'description' => 'Computer Engineering combines electrical engineering and computer science to design and build computer systems.',
                'course_name' => 'Computer Engineering'
            ],
            [
                'title' => 'B.Sc. Mass Communication',
                'slug' => 'bsc-mass-communication',
                'category' => 'undergraduate',
                'level' => 'Bachelor',
                'degree' => 'B.Sc.',
                'faculty' => 'Faculty of Social Sciences',
                'duration' => 4,
                'description' => 'Mass Communication covers journalism, broadcasting, public relations, and digital media.',
                'course_name' => 'Mass Communication'
            ],
             [
                'title' => 'M.Sc. Computer Science',
                'slug' => 'msc-computer-science',
                'category' => 'postgraduate',
                'level' => 'Master',
                'degree' => 'M.Sc.',
                'faculty' => 'Postgraduate School',
                'duration' => 2,
                'description' => 'Advanced study in computer science topics including AI, data science, and software engineering.',
                'course_name' => 'Computer Science (PG)'
            ]
        ];

        foreach ($programs as $data) {
            // Create Course
            $course = WebsiteCourse::firstOrCreate(
                ['slug' => Str::slug($data['course_name'])],
                [
                    'course_name' => $data['course_name'],
                    'faculty' => $data['faculty'],
                    'is_active' => true
                ]
            );

            // Create Program
            WebsiteProgram::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'program_category' => $data['category'],
                    'program_level' => $data['level'],
                    'degree' => $data['degree'],
                    'faculty' => $data['faculty'],
                    'duration' => $data['duration'],
                    'program_description' => $this->createRichText($data['description']),
                    'eligibility_criteria' => $this->createRichText('Five O’Level credits including Mathematics and English.'),
                    'how_to_apply' => $this->createRichText('Apply online via the university portal.'),
                    'financial_aid' => $this->createRichText('Scholarships available for meritorious students.'),
                    'transfer_candidates' => $this->createRichText('Transcripts required from previous institution.'),
                    'course_id' => $course->id,
                    'is_active' => ActiveStatus::ACTIVE,
                ]
            );
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question' => 'How do I apply for admission?',
                'answer' => 'You can apply for admission by visiting our Admissions page and filling out the online application form.',
                'category' => 'Admissions'
            ],
            [
                'question' => 'What are the tuition fees?',
                'answer' => 'Tuition fees vary by program. Please visit the Fees page for a detailed breakdown of costs.',
                'category' => 'Finance'
            ],
            [
                'question' => 'Is there accommodation on campus?',
                'answer' => 'Yes, Veritas University provides comfortable and secure hostel accommodation for students.',
                'category' => 'Campus Life'
            ],
            [
                'question' => 'Do you offer scholarships?',
                'answer' => 'Yes, we offer various scholarships based on academic merit and financial need.',
                'category' => 'General'
            ],
            [
                'question' => 'How can I contact the university?',
                'answer' => 'You can contact us via email at info@veritas.edu.ng or call our helpline numbers listed on the Contact page.',
                'category' => 'General'
            ]
        ];

        foreach ($faqs as $index => $faq) {
            WebsiteFaq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'category' => $faq['category'],
                    'order' => $index + 1,
                    'is_active' => ActiveStatus::ACTIVE
                ]
            );
        }
    }

    private function seedAZEntries(): void
    {
        $entries = [
            'A' => [
                ['name' => 'About Us', 'link' => '/about', 'description' => 'Get to know Veritas University, its mission, and history.'],
                ['name' => 'Admissions', 'link' => '/admissions', 'description' => 'Start your journey—review admission requirements and how to apply.'],
            ],
            'C' => [
                ['name' => 'Chaplaincy at Veritas', 'link' => '/chaplaincy', 'description' => 'Learn about our spiritual support and chaplaincy services.'],
                ['name' => 'Campus Life', 'link' => '/campus-life', 'description' => 'Experience student life, clubs, facilities, and more at Veritas.'],
            ],
            'F' => [
                ['name' => 'FAQ', 'link' => '/faq', 'description' => 'Find answers to commonly asked questions about Veritas University.'],
            ],
            'H' => [
                ['name' => 'Home', 'link' => '/', 'description' => 'Welcome to Veritas University – your gateway to academic excellence.'],
            ],
            'N' => [
                ['name' => 'News and Events', 'link' => '/news-and-events', 'description' => 'Stay updated with the latest happenings at Veritas.'],
            ],
            'R' => [
                ['name' => 'Research', 'link' => '/research', 'description' => 'Explore our commitment to advancing knowledge through impactful research.'],
            ],
            'U' => [
                ['name' => 'Undergraduate', 'link' => '/undergraduate', 'description' => 'Discover our undergraduate programs.'],
                ['name' => 'University Management', 'link' => '/university-management', 'description' => 'Meet the leadership team.'],
            ],
        ];

        foreach ($entries as $alphabet => $items) {
            foreach ($items as $item) {
                WebsiteAZEntry::updateOrCreate(
                    ['topic' => $item['name']],
                    [
                        'alphabet' => $alphabet,
                        'slug' => Str::slug($item['name']),
                        'link' => $item['link'],
                        'description' => $item['description'],
                        'is_active' => ActiveStatus::ACTIVE,
                    ]
                );
            }
        }
    }

    private function seedManagement(): void
    {
        $management = [
            [
                'name' => 'Prof. Hyacinth E. Ichoku',
                'title' => 'Prof.',
                'position' => 'Vice Chancellor',
                'slug' => 'vice-chancellor',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491782/sisi-2689_xk5trj.jpg',
                'email' => 'vc@veritas.edu.ng',
                'biography' => $this->createRichText('Professor Hyacinth E. Ichoku is the Vice Chancellor of Veritas University, Abuja. He is a Professor of Development Economics with over 25 years of experience in teaching, research, and university administration.')
            ],
            [
                'name' => 'Dr. Mrs. Stella C. Okonkwo',
                'title' => 'Dr.',
                'position' => 'Registrar',
                'slug' => 'registrar',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491844/Vuna-2570_aewufs.jpg',
                'email' => 'registrar@veritas.edu.ng',
                'biography' => $this->createRichText('Dr. Mrs. Stella C. Okonkwo is the Registrar of Veritas University. She is responsible for the administrative machinery of the University.')
            ],
            [
                'name' => 'Rev. Fr. Dr. Peter Bakwaph',
                'title' => 'Rev. Fr. Dr.',
                'position' => 'Deputy Vice Chancellor',
                'slug' => 'deputy-vice-chancellor',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491760/sisi-2675_f85nfl.jpg',
                'email' => 'dvc@veritas.edu.ng',
                'biography' => $this->createRichText('Rev. Fr. Dr. Peter Bakwaph is the Deputy Vice Chancellor. He assists the Vice Chancellor in the academic and administrative leadership of the University.')
            ],
             [
                'name' => 'Most Rev. Dr. Matthew Hassan Kukah',
                'title' => 'Most Rev. Dr.',
                'position' => 'Chancellor',
                'slug' => 'chancellor',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491845/Vuna-2495_anpcht.jpg',
                'email' => 'chancellor@veritas.edu.ng',
                'biography' => $this->createRichText('Most Rev. Dr. Matthew Hassan Kukah is the Chancellor of Veritas University and the Catholic Bishop of Sokoto Diocese.')
            ],
            [
                'name' => 'Rev. Fr. Martin Onukwuba',
                'title' => 'Rev. Fr.',
                'position' => 'University Chaplain',
                'slug' => 'chaplain',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491765/sisi-2691_xxya1f.jpg',
                'email' => 'chaplain@veritas.edu.ng',
                'biography' => $this->createRichText('Rev. Fr. Martin Onukwuba is the University Chaplain, responsible for the spiritual welfare of the University community.')
            ]
        ];

        foreach ($management as $person) {
            WebsitePersonnel::updateOrCreate(
                ['slug' => $person['slug']],
                array_merge($person, ['is_active' => ActiveStatus::ACTIVE])
            );
        }
    }

    private function seedNews(): void
    {
        $news = [
            [
                'heading' => 'Veritas University Wins National Debate Championship',
                'subheading' => 'Our students have done it again!',
                'slug' => 'debate-championship-win',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg',
                'overview' => $this->createRichText('Veritas University debate team has emerged victorious at the National Universities Debate Championship held in Lagos.'),
                'content' => $this->createRichText('The Veritas University debate team has once again demonstrated academic excellence by winning the National Universities Debate Championship. The team, comprising students from various departments, defeated 20 other universities to clinch the trophy. The Vice Chancellor, Prof. Hyacinth Ichoku, congratulated the team and commended their hard work and dedication.'),
                'author' => 'Media Team',
                'published_at' => now(),
                'average_time_to_read' => '5 min read'
            ],
            [
                'heading' => 'Admissions Open for 2025/2026 Academic Session',
                'subheading' => 'Apply now for Undergraduate and Postgraduate programs',
                'slug' => 'admissions-open-2025',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491827/Vuna-1971.jpg-_k99bco.jpg',
                'overview' => $this->createRichText('Applications are now invited from suitably qualified candidates for admission into Veritas University for the 2025/2026 academic session.'),
                'content' => $this->createRichText('Veritas University, Abuja, has commenced the sale of application forms for the 2025/2026 academic session. Interested candidates can apply for various Undergraduate and Postgraduate programs. The University offers a serene learning environment, modern facilities, and a commitment to moral and academic excellence. Visit the admissions portal to apply.'),
                'author' => 'Admissions Unit',
                'published_at' => now()->subDays(2),
                'average_time_to_read' => '3 min read'
            ],
             [
                'heading' => 'Convocation Ceremony Set for November',
                'subheading' => 'Celebrating our graduating students',
                'slug' => 'convocation-ceremony-2025',
                'image_url' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492279/MTG-4591_e2a3hv.jpg',
                'overview' => $this->createRichText('Veritas University is set to hold its 14th Convocation Ceremony this November to celebrate the achievements of its graduating students.'),
                'content' => $this->createRichText('The Vice Chancellor has announced that the 14th Convocation Ceremony of Veritas University will take place in November 2025. The event will feature the award of degrees, presentation of prizes, and the investiture of the new Chancellor. Parents, guardians, and the general public are invited to join in the celebration.'),
                'author' => 'Registry',
                'published_at' => now()->subDays(5),
                'average_time_to_read' => '4 min read'
            ]
        ];

        foreach ($news as $item) {
            WebsiteNews::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, ['is_active' => ActiveStatus::ACTIVE])
            );
        }
    }
}
