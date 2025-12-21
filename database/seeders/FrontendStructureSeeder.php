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
use App\Enums\PageStatus;
use App\Enums\ActiveStatus;
use App\Enums\FeatureStatus;
use Illuminate\Support\Str;

class FrontendStructureSeeder extends Seeder
{
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

        // 7. Seed A-Z Entries
        $this->seedAZEntries();

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
                            'content1' => '<p>Join Veritas University and unlock your potential with our world-class education, modern facilities, and inspiring campus life.</p>',
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
                                ['id' => '1', 'title' => 'Admissions', 'description' => 'Learn about our admissions process and deadlines.', 'link' => '/admissions', 'linkText' => 'Explore Admissions'],
                                ['id' => '2', 'title' => 'Programs', 'description' => 'Explore our undergraduate and postgraduate programs.', 'link' => '/undergraduate', 'linkText' => 'View Programs'],
                                ['id' => '3', 'title' => 'Student Portal', 'description' => 'Access academic records, course materials, and more.', 'link' => 'https://admission.veritas.edu.ng/admission', 'linkText' => 'Go to Portal']
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
                                    'title' => 'faculty of mbbs',
                                    'subtitle' => 'Medicine',
                                    'description' => 'The Computer Science Department at our institution is dedicated to providing cutting-edge education and research opportunities in the rapidly evolving field of computer',
                                    'href' => '/undergraduate/mbbs-medicine-and-surgery',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491849/Vuna-4625_pnjzzx.jpg',
                                    'size' => 'lg'
                                ],
                                [
                                    'title' => 'faculty of health sciences',
                                    'subtitle' => 'Nursing science',
                                    'href' => '/undergraduate/bsc-nursing-science',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491816/sisi-4557_bdzki6.jpg'
                                ],
                                [
                                    'title' => 'faculty of engineering',
                                    'subtitle' => 'Computer Engineering',
                                    'href' => '/undergraduate/b-eng-computer-engineering',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745491832/Vuna-2019.jpg-_yftz3a.jpg'
                                ],
                                [
                                    'title' => 'faculty of social sciences',
                                    'subtitle' => 'Mass Communication',
                                    'href' => '/undergraduate/bsc-mass-communication',
                                    'imgSrc' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492266/MTG-2188_skcr9g.jpg'
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
                            'content1' => '<p>Explore our commitment to advancing knowledge through impactful research.</p>',
                            'imageUrl1' => 'https://res.cloudinary.com/dbhjueg2l/image/upload/v1745492224/MTG-4553_tuouqt.jpg',
                            'heading2' => '200', 'content2' => 'Peer-Reviewed Papers Published Annually',
                            'heading3' => '50', 'content3' => 'Ongoing Research Initiatives',
                            'heading4' => '30', 'content4' => 'Partnerships with Leading Organizations'
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
                            'heading1' => '300', 'content1' => 'Undergraduate and Postgraduate students across different Programmes',
                            'heading2' => '10000', 'content2' => 'Alumni worldwide making visible impacts and contributing to global development.',
                            'heading3' => '20000000', 'content3' => 'Grants given to local communities around the institution and beyond.',
                            'heading4' => '56', 'content4' => 'Academic professors lecturing, researching and contributing to community.',
                            'heading5' => '2002', 'content5' => 'Our establishment by an Act of Parliament',
                            'heading6' => '15', 'content6' => 'Research Institutes across several interdisciplinary boundaries'
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
                            'content1' => '<p>Veritas University is a dynamic community of learning, founded on the Catholic tradition of academic excellence and moral formation. We are committed to nurturing the next generation of leaders who will transform society through knowledge and integrity.</p>',
                            'content2' => '<p>Our campus offers a serene and conducive environment for intellectual pursuit, spiritual growth, and social interaction. We believe in the holistic development of every student.</p>',
                            'imageUrl1' => '/assets/images/about/buildingOne.jpg'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-second-section',
                        'name' => 'Our Journey',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'Our Journey',
                            'content1' => '<p>Founded in 2002 by the Catholic Bishops Conference of Nigeria, Veritas University has grown from humble beginnings to become a premier institution of higher learning.</p>',
                            'content2' => '<p>Licensed by the National Universities Commission in 2007, we have consistently upheld high academic standards.</p>',
                            'content3' => '<p>We commenced academic activities in Obehie, Abia State, before moving to our permanent site.</p>',
                            'content4' => '<p>Relocated to the permanent campus in Abuja in 2008, expanding our facilities and programs.</p>',
                            'content5' => '<p>Today, we continue to grow with new faculties, research centers, and a diverse student body.</p>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-third-section',
                        'name' => 'Foundation & History',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'Foundation',
                            'content1' => '<p>Veritas University, Abuja (VUNA) is the Catholic University of Nigeria, established to provide high-quality education balanced with moral and spiritual values.</p>',
                            'heading2' => 'Mission',
                            'content2' => '<p>To provide integral education that combines academic excellence with moral and spiritual formation, empowering students to become ethical leaders.</p>',
                            'heading3' => 'Vision',
                            'content3' => '<p>To be a top-class university recognized globally for research, teaching, and community service.</p>',
                            'heading4' => 'Philosophy',
                            'content4' => '<p>To produce graduates who are theoretically knowledgeable and practically skillful, ready to contribute to national development.</p>',
                            'heading5' => 'Core Values',
                            'content5' => '<ul><li>Academic Excellence</li><li>Moral Integrity</li><li>Service to Humanity</li><li>Social Justice</li></ul>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'about-page-fourth-section',
                        'name' => 'Management Team',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'University Management',
                            'content1' => '<p>Meet the dedicated team leading Veritas University towards achieving its strategic goals.</p>',
                            'content2' => '<p>Our management team comprises experienced administrators and distinguished academics committed to excellence.</p>',
                            'imageUrl1' => '/assets/images/about/founder.jpg'
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
                            'content1' => '<p>Start your academic journey with our diverse undergraduate programs. We offer a wide range of courses designed to prepare you for a successful career.</p>',
                            'imageUrl1' => '/assets/images/admissions/undergrad-1.jpg',
                            'imageUrl2' => '/assets/images/admissions/undergrad-2.jpg',
                            'list' => 'Minimum of 5 Credits in WAEC/NECO === UTME Score of 170+ === Birth Certificate === Testimonial'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-jupeb-page',
                        'name' => 'JUPEB Admissions',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'JUPEB Program',
                            'content1' => '<p>Gain direct entry into 200 level through our JUPEB program. It is an intensive one-year foundation course.</p>',
                            'imageUrl1' => '/assets/images/admissions/jupeb-1.jpg',
                            'imageUrl2' => '/assets/images/admissions/jupeb-2.jpg',
                            'list' => '5 Credits in O-Level === Passport Photographs === Birth Certificate'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-ijamb-page',
                        'name' => 'IJMB Admissions',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'IJMB Program',
                            'content1' => '<p>Secure admission into university without JAMB through IJMB. Recognized widely for direct entry admission.</p>',
                            'imageUrl1' => '/assets/images/admissions/ijmb-1.jpg',
                            'imageUrl2' => '/assets/images/admissions/ijmb-2.jpg',
                            'list' => 'O-Level Results === Birth Certificate === State of Origin'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-sandwich-page',
                        'name' => 'Sandwich Admissions',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'Sandwich Program',
                            'content1' => '<p>Flexible learning options for working professionals. Enhance your qualifications while you work.</p>',
                            'imageUrl1' => '/assets/images/admissions/sandwich-1.jpg',
                            'imageUrl2' => '/assets/images/admissions/sandwich-2.jpg',
                            'list' => 'NCE/Diploma Certificate === O-Level Results === Employment Letter (if applicable)'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'admission-postgraduate-page',
                        'name' => 'Postgraduate Admissions',
                        'order' => 5,
                        'content' => [
                            'heading1' => 'Postgraduate School',
                            'content1' => '<p>Advance your career with our Masters and PhD programs. Engage in advanced research and scholarship.</p>',
                            'imageUrl1' => '/assets/images/admissions/pg-1.jpg',
                            'imageUrl2' => '/assets/images/admissions/pg-2.jpg',
                            'list' => 'First Degree Certificate === NYSC Discharge/Exemption === O-Level Results === Transcript'
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
                            'content1' => '<p>Veritas University offers a vibrant campus life experience, fostering community, personal growth, and academic excellence.</p>',
                            'list' => [
                                '/assets/images/campus/collaboration.jpg === /assets/images/campus/hanging-out.jpg',
                                '/assets/images/campus/soccer-game.jpg === /assets/images/campus/cultural-day.jpg',
                                '/assets/images/campus/male-students.jpg === /assets/images/campus/basketball.jpg',
                                '/assets/images/campus/dance.jpg === /assets/images/campus/yoga.jpg'
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
                                    'imageUrl1' => '/assets/images/campus/protestors.jpg',
                                    'content1' => '<p>A Student Representative Assembly (SRA) in a Catholic university context serves as the official voice of the student body, representing student interests while operating within the university\'s Catholic mission and values.</p><p>The SRA acts as the primary governing body for student affairs, creating a structured channel for student participation in university governance.</p>'
                                ],
                                [
                                    'heading1' => 'NFCS === Nigerian Federation of Catholic Students',
                                    'imageUrl1' => '/assets/images/campus/cathedral.jpg',
                                    'content1' => '<p>The Nigerian Federation of Catholic Students (NFCS) unites Catholic students to foster their spiritual growth and active participation in the Church\'s mission.</p>'
                                ],
                                [
                                    'heading1' => 'VERITAS SPORTS === Veritas University Sports Center',
                                    'imageUrl1' => '/assets/images/campus/track.jpg',
                                    'content1' => '<p>Veritas Sports Center provides state-of-the-art facilities for various sports, promoting physical fitness and team spirit among students.</p>'
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
                            'content1' => '<p>Nurturing the spiritual life of the Veritas community.</p>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy-page-second-section',
                        'name' => 'Our Focus',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'Our Spiritual Focus',
                            'content1' => '<p>We focus on the holistic formation of our students through prayer, sacraments, and service.</p>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy-page-third-section',
                        'name' => 'The Holy See',
                        'order' => 3,
                        'content' => [
                            'heading1' => 'The Holy See',
                            'content1' => '<p>Guided by the teachings of the Catholic Church and the Holy Father.</p>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'chaplaincy_mass',
                        'name' => 'Mass Schedules',
                        'order' => 4,
                        'content' => [
                            'heading1' => 'Mass Schedules',
                            'content1' => '<p>Daily Mass: 6:30 AM, 12:00 PM</p><p>Sunday Mass: 7:00 AM, 9:00 AM</p>'
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
                            'content1' => '<p>We are committed to providing affordable quality education. Find detailed information about tuition, accommodation, and other fees here.</p>'
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
                            'content1' => '<p>We are a research-intensive university committed to solving local and global challenges through innovative research.</p>'
                        ]
                    ],
                    [
                        'type' => 'template',
                        'identifier' => 'research-page-third-section',
                        'name' => 'SDGs',
                        'order' => 2,
                        'content' => [
                            'heading1' => 'Sustainable Development Goals',
                            'content1' => '<p>Our research is aligned with the United Nations Sustainable Development Goals (SDGs), focusing on impactful solutions for a better world.</p>'
                        ]
                    ],
                    [
                        'type' => 'system',
                        'identifier' => 'research-groups-list',
                        'name' => 'Research Groups',
                        'order' => 3,
                        'content' => [
                            'heading' => 'Our Research Groups',
                            'subheading' => 'Explore our specialized research teams.'
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
                            'content1' => '<p>Stay updated with the latest happenings at Veritas University.</p>'
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
                            'content1' => '<p>Join our vibrant community of learners and leaders. Discover programs that ignite your passion and prepare you for the future.</p>',
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
                            'content1' => '<p>Experienced Faculty, Practical Learning, and Career Growth.</p>'
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
                            'content1' => '<p>Advance your career with our world-class postgraduate programs. Engage in research that matters.</p>',
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
                            'content1' => '<p>Use this comprehensive directory to quickly access all departments, services, programs, and university resources. Browse alphabetically or search to find what you’re looking for.</p>'
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
                            'content1' => '<p>Find answers to the most common questions about admissions, academics, campus life, and student services. Still need help? Our team is here to support you.</p>'
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
                        'identifier' => 'management-page-hero',
                        'name' => 'Hero Section',
                        'order' => 1,
                        'content' => [
                            'heading1' => 'University Management',
                            'content1' => '<p>Meet the visionary leaders guiding Veritas University towards excellence.</p>'
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
                'description' => 'The Debate Club fosters critical thinking and public speaking skills through regular debates and competitions.',
                'member_count' => '45+',
                'image_url' => '/assets/images/campus/debate-club.jpg'
            ],
            [
                'title' => 'Dance Group',
                'description' => 'Our Dance Group explores various dance styles and performs at university events and competitions.',
                'member_count' => '45+',
                'image_url' => '/assets/images/campus/dance-club.jpg'
            ],
            [
                'title' => 'Drama Group',
                'description' => 'The Drama Group stages plays and theatrical performances, nurturing acting and production talents.',
                'member_count' => '45+',
                'image_url' => '/assets/images/campus/drama-club.jpg'
            ],
            [
                'title' => 'Musical Group',
                'description' => 'The Musical Group brings together vocalists and instrumentalists to perform diverse musical genres.',
                'member_count' => '45+',
                'image_url' => '/assets/images/campus/music-club.jpg'
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
                'heading' => 'Universities Football Clubs',
                'image_url' => '/assets/images/campus/soccer-game-2.jpg',
                'event_type' => 'social'
            ],
            [
                'heading' => 'Student Week',
                'image_url' => '/assets/images/campus/student-week.jpg',
                'event_type' => 'social'
            ],
            [
                'heading' => 'Hausa Community Wins Cultural Competition Cup',
                'image_url' => '/assets/images/campus/dance-performance.jpg',
                'event_type' => 'social'
            ],
            [
                'heading' => 'Golden Boys Won The Trophy With Penalty Shootout',
                'image_url' => '/assets/images/campus/sports.jpg',
                'event_type' => 'social'
            ],
            [
                'heading' => 'Amazulu vs Golden Boys',
                'image_url' => '/assets/images/campus/soccer-game.jpg',
                'event_type' => 'social'
            ],
            [
                'heading' => 'Cultural Competition',
                'image_url' => '/assets/images/campus/cultural-day.jpg',
                'event_type' => 'social'
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
                'title' => 'Software Engineering Research Group',
                'description' => 'Focusing on AI, Machine Learning, and Software Development methodologies.',
                'image_url' => '/assets/images/research/software.jpg',
            ],
            [
                'title' => 'Biotechnology Research Cluster',
                'description' => 'Advancing health and agriculture through biotechnology innovations.',
                'image_url' => '/assets/images/research/biotech.jpg',
            ],
            [
                'title' => 'Social Sciences & Development',
                'description' => 'Researching societal issues, policy, and sustainable development.',
                'image_url' => '/assets/images/research/social-science.jpg',
            ]
        ];

        foreach ($groups as $group) {
            WebsiteResearchGroup::updateOrCreate(
                ['title' => $group['title']],
                [
                    'slug' => Str::slug($group['title']),
                    'description' => $group['description'],
                    'image_url' => $group['image_url'],
                    'is_active' => ActiveStatus::ACTIVE,
                    'spotlight' => ['featured' => true]
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
                    'program_description' => ['content' => $data['description']],
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
}
