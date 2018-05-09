<?php
use \App\Libraries\GeneralConstant;
use Illuminate\Database\Seeder;
use App\Models\Project;
class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'name' => 'PHP/Python Developer',
            'company_id' => '1',
            'is_fulltime'=>'1',
            'status' => GeneralConstant::PROJECT_HIRING,
            'address'=>'',
            'length'=>15,
            'need_min'=>5,
            'need_max'=>10,
            'intro'=>'Thời gian làm việc:
                    Full time hoặc Part time (sáng/chiều)
                    Thứ 2 đến Thứ 6: 8h30 – 18h00
                    Quyền lợi khi tham gia chương trình Thực tập sinh tại công ty OneTech
                    Được làm việc trong môi trường chuyên nghiệp, sử dụng tiếng Nhật.
                    Được đào tạo chuyên sâu về các ngôn ngữ lập trình, các công nghệ mới nhất.
                    Được đào tạo theo mô hình, quy trình làm việc tại một công ty Nhật Bản.
                    Được tham gia dự án thật với các khách hàng nước ngoài.
                    Được đào tạo về các quy trình kiểm thử phần mềm, Web.
                    Cơ hội trở thành nhân viên chính thức sau thời gian đào tạo và thử việc.',
            'requirement'=>'Sinh viên năm 3, 4 Đại học chuyên ngành CNTT hoặc các chuyên ngành liên quan có thành tích học tập tốt.
                            Có đam mê và yêu thích công việc lập trình.
                            Có kiến thức về các công nghệ cơ bản như HTML/CSS, AJAX, Javascript.
                            Có kiến thức về lập trình hướng đối tượng OOP và mô hình MVC.
                            Có kinh nghiệm làm việc với các CMS (WordPress, Joomla) hoặc các PHP Framework (Zend Framework, Yii, Prado, CodeIgniter, Kohana, CakePHP...).',
            'plus_point'=>'Proficiency in using Design Patterns is a big plus
                         Experience in working with 3rd libraries is a big plus
                         Experience with In-App Purchase & iTunesConnect is a plus
                         Be passionate of new technologies and be eager to learn from each other.',
            'extra_file'=>'',
            'num_of_applied'=>0,
            'num_of_joined'=>0,
            'start_date'=>strtotime(date('2016-11-04')),
            'publish_date'=>strtotime(date('2016-11-04')),
            'contact_email'=>'dachuu25@gmail.com',
            'created_by_agent_id'=>'1',
        ]);
        Project::create([
            'name' => 'FrontEnd Developer',
            'company_id' => '1',
            'is_fulltime'=>'0',
            'status' => GeneralConstant::PROJECT_HIRING,
            'address'=>'',
            'length'=>30,
            'need_min'=>5,
            'need_max'=>10,
            'intro'=>'Thời gian làm việc:
                    Full time hoặc Part time (sáng/chiều)
                    Thứ 2 đến Thứ 6: 8h30 – 18h00
                    Quyền lợi khi tham gia chương trình Thực tập sinh tại công ty OneTech
                    Được làm việc trong môi trường chuyên nghiệp, sử dụng tiếng Nhật.
                    Được đào tạo chuyên sâu về các ngôn ngữ lập trình, các công nghệ mới nhất.
                    Được đào tạo theo mô hình, quy trình làm việc tại một công ty Nhật Bản.
                    Được tham gia dự án thật với các khách hàng nước ngoài.
                    Được đào tạo về các quy trình kiểm thử phần mềm, Web.
                    Cơ hội trở thành nhân viên chính thức sau thời gian đào tạo và thử việc.',
            'requirement'=>'Sinh viên năm 3, 4 Đại học chuyên ngành CNTT hoặc các chuyên ngành liên quan có thành tích học tập tốt.
                            Có đam mê và yêu thích công việc lập trình.
                            Có kiến thức về các công nghệ cơ bản như HTML/CSS, AJAX, Javascript.
                            Có kiến thức về lập trình hướng đối tượng OOP và mô hình MVC.
                            Có kinh nghiệm làm việc với các CMS (WordPress, Joomla) hoặc các PHP Framework (Zend Framework, Yii, Prado, CodeIgniter, Kohana, CakePHP...).',
            'plus_point'=>'Proficiency in using Design Patterns is a big plus
                         Experience in working with 3rd libraries is a big plus
                         Experience with In-App Purchase & iTunesConnect is a plus
                         Be passionate of new technologies and be eager to learn from each other.',
            'extra_file'=>'',
            'num_of_applied'=>1,
            'num_of_joined'=>0,
            'start_date'=>strtotime(date('2016-11-04')),
            'publish_date'=>strtotime(date('2016-11-04')),
            'contact_email'=>'dachuu25@gmail.com',
            'created_by_agent_id'=>'1',
        ]);
        Project::create([
            'name' => 'BackEnd Developer',
            'company_id' => '1',
            'is_fulltime'=>'0',
            'status' => GeneralConstant::PROJECT_HIRING,
            'address'=>'',
            'length'=>30,
            'need_min'=>5,
            'need_max'=>10,
            'intro'=>'Thời gian làm việc:
                    Full time hoặc Part time (sáng/chiều)
                    Thứ 2 đến Thứ 6: 8h30 – 18h00
                    Quyền lợi khi tham gia chương trình Thực tập sinh tại công ty OneTech
                    Được làm việc trong môi trường chuyên nghiệp, sử dụng tiếng Nhật.
                    Được đào tạo chuyên sâu về các ngôn ngữ lập trình, các công nghệ mới nhất.
                    Được đào tạo theo mô hình, quy trình làm việc tại một công ty Nhật Bản.
                    Được tham gia dự án thật với các khách hàng nước ngoài.
                    Được đào tạo về các quy trình kiểm thử phần mềm, Web.
                    Cơ hội trở thành nhân viên chính thức sau thời gian đào tạo và thử việc.',
            'requirement'=>'Sinh viên năm 3, 4 Đại học chuyên ngành CNTT hoặc các chuyên ngành liên quan có thành tích học tập tốt.
                            Có đam mê và yêu thích công việc lập trình.
                            Có kiến thức về các công nghệ cơ bản như HTML/CSS, AJAX, Javascript.
                            Có kiến thức về lập trình hướng đối tượng OOP và mô hình MVC.
                            Có kinh nghiệm làm việc với các CMS (WordPress, Joomla) hoặc các PHP Framework (Zend Framework, Yii, Prado, CodeIgniter, Kohana, CakePHP...).',
            'plus_point'=>'Proficiency in using Design Patterns is a big plus
                         Experience in working with 3rd libraries is a big plus
                         Experience with In-App Purchase & iTunesConnect is a plus
                         Be passionate of new technologies and be eager to learn from each other.',
            'extra_file'=>'',
            'num_of_applied'=>0,
            'num_of_joined'=>0,
            'start_date'=>strtotime(date('2016-11-04')),
            'publish_date'=>strtotime(date('2016-11-04')),
            'contact_email'=>'dachuu25@gmail.com',
            'created_by_agent_id'=>'1',
        ]);
        Project::create([
            'name' => 'Mobile Developer',
            'company_id' => '1',
            'is_fulltime'=>'1',
            'status' => GeneralConstant::PROJECT_HIRING,
            'address'=>'',
            'length'=>30,
            'need_min'=>5,
            'need_max'=>10,
            'intro'=>'Thời gian làm việc:
                    Full time hoặc Part time (sáng/chiều)
                    Thứ 2 đến Thứ 6: 8h30 – 18h00
                    Quyền lợi khi tham gia chương trình Thực tập sinh tại công ty OneTech
                    Được làm việc trong môi trường chuyên nghiệp, sử dụng tiếng Nhật.
                    Được đào tạo chuyên sâu về các ngôn ngữ lập trình, các công nghệ mới nhất.
                    Được đào tạo theo mô hình, quy trình làm việc tại một công ty Nhật Bản.
                    Được tham gia dự án thật với các khách hàng nước ngoài.
                    Được đào tạo về các quy trình kiểm thử phần mềm, Web.
                    Cơ hội trở thành nhân viên chính thức sau thời gian đào tạo và thử việc.',
            'requirement'=>'Sinh viên năm 3, 4 Đại học chuyên ngành CNTT hoặc các chuyên ngành liên quan có thành tích học tập tốt.
                            Có đam mê và yêu thích công việc lập trình.
                            Có kiến thức về các công nghệ cơ bản như HTML/CSS, AJAX, Javascript.
                            Có kiến thức về lập trình hướng đối tượng OOP và mô hình MVC.
                            Có kinh nghiệm làm việc với các CMS (WordPress, Joomla) hoặc các PHP Framework (Zend Framework, Yii, Prado, CodeIgniter, Kohana, CakePHP...).',
            'plus_point'=>'Proficiency in using Design Patterns is a big plus
                         Experience in working with 3rd libraries is a big plus
                         Experience with In-App Purchase & iTunesConnect is a plus
                         Be passionate of new technologies and be eager to learn from each other.',
            'extra_file'=>'',
            'num_of_applied'=>1,
            'num_of_joined'=>0,
            'start_date'=>strtotime(date('2016-11-04')),
            'publish_date'=>strtotime(date('2016-11-04')),
            'contact_email'=>'dachuu25@gmail.com',
            'created_by_agent_id'=>'1',
        ]);
    }
}
