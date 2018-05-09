<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name'=>'VietnamEsport',
            'url'=>'vietnamesport.com',
            'address'=>'15 Trương Định, phường 6, Hồ Chí Minh, phường 6 Quận 3 Hồ Chí Minh, Việt Nam',
            'phone'=>'(84-8) 7305 3939',
            'rating'=>'4'
        ]);
        Company::create([
            'name'=>'Facebook Inc',
            'address'=>'Menlo Park, California, Hoa Kỳ',
            'url'=>'vietnamesport.com',
            'phone'=>'(84-8) 7305 3939',
            'rating'=>'1'
        ]);
        Company::create([
            'name'=>'Trobz',
            'url'=>'trobz.com',
            'address'=>'47/2/57 Bui Dinh Tuy, Binh Thanh District, Ho Chi Minh City, Vietnam',
            'phone'=>'(84-8) 7305 3939',
            'rating'=>'3'
        ]);
    }
}
