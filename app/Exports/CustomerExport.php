<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customer_names = Customer::groupBy('name')->pluck('name');
     //  dd($customer_names);
        $current_date = Date('Y-m-d',);
        $back_date = Date('Y-m-d',strtotime('-0 days'));
        $data = [];

            foreach($customer_names as $key=>$name){
                //dd(1);
                $data[$key]['name'] = $name;
                for($i=30; $i>=0; $i--){
                    $dt = Date('Y-m-d',strtotime("-$i days"));
                    $customer = Customer::select('point')->where('post_date',$dt)->where('name',$name)->first();
                    if($customer){
                        $data[$key][$dt] = $customer->point;
                    }
                }
            }

          $total_data = ['name'=>'Total'];
          foreach( $data as $element_arr)
          {
            foreach($element_arr as $key=>$val)
            {
                if($key != 'name'){
                    $total_data[$key] = (!empty($total_data[$key]))?$total_data[$key]+$val: $val;
                    //$val[]
                }

            }
          }
        array_push($data,$total_data);
         // dd($temp_data);

        return collect($data);
    }

    public function headings(): array
    {

        $customer_names = Customer::groupBy('name')->pluck('name');

        $current_date = Date('Y-m-d',);
        $back_date = Date('Y-m-d',strtotime('-0 days'));
        $data = ['customer name'];


            foreach($customer_names as $key=>$name){

                for($i=30;$i>=0;$i--){
                    $dt = Date('Y-m-d',strtotime("-$i days"));
                    $customer = Customer::select('point')->where('post_date',$dt)->where('name',$name)->first();
                    if($customer){

                        if(!in_array($dt,$data)){
                            array_push($data,$dt);
                        }

                    }
                }
            }


        return $data;
    }
}
