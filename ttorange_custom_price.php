<?php
/*
* Plugin Name: ttorange custom plugintable price
* Plugin URI: http://ttorange.com
* Description: this plugin made for easy update prices
* Author: Alireza Sayyah
* Version: 2.0
* Text Domain: TTorange Company
*/



function ttorange_setprice_api(WP_REST_Request $request){
    if($request['apikey']=="API_KEY"){
        $sellprice=$request['sell'];
        $buyprice=$request['buy'];
        $rate=$request['rate'];
        $myfile = fopen("wp-content/plugins/ttorange_custom_price/newfile.txt", "w") or die("Unable to open file!");
        $txt = "sell:".$sellprice."--buy:".$buyprice."--rate:".$rate;
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "done";
    }else{
        echo "access denied";
    }
}

function ttorange_getprice_api(WP_REST_Request $request){
    if($request['apikey']=="API_KEY"){
        $myfile = fopen("wp-content/plugins/ttorange_custom_price/newfile.txt", "r") or die("Unable to open file!".getcwd());
        $arr=explode("--",fgets($myfile));
        $sell=explode(":",$arr[0]);
        $buy=explode(":",$arr[1]);
        $rate=explode(":",$arr[2]);
        $data[0]['sell']=$sell[1];
        $data[0]['buy']=$buy[1];
        $data[0]['rate']=$rate[1];
        echo json_encode($data);
    }else{
        echo "access denied";
    }
}


function ttorange_price_table() { 
    $myfile = fopen("wp-content/plugins/PLUGIN_FOLDER_NAME/newfile.txt", "r") or die("Unable to open file!");
    $arr=explode("--",fgets($myfile));
    $sell=explode(":",$arr[0]);
    $buy=explode(":",$arr[1]);
    $sellPrice=$sell[1];
    $buyPrice=$buy[1];
    $message = '<div class="sh-table-element sh-table-element-style1 fw-table" id="table-9730087b2db47e6072fd61a7ac553154"><table><thead><tr class="heading-row"><th class="default-col">Currency</th><th class="default-col">Sell</th><th class="default-col">Buy</th></tr></thead><tr class="default-row"><td class="default-col">Canada dollar</td><td class="default-col">'.$sellPrice.'</td><td class="default-col">'.$buyPrice.'</td></tr></table></div>'; 
    return $message;
    } 
add_shortcode('ttorange_table', 'ttorange_price_table'); 

function ttorange_rate_table() { 
    $myfile = fopen("wp-content/plugins/PLUGIN_FOLDER_NAME/newfile.txt", "r") or die("Unable to open file!");
    $arr=explode("--",fgets($myfile));
    $rate=explode(":",$arr[2]);
    $ratechange=$rate[1];
    $message = '<div class="sh-table-element sh-table-element-style1 fw-table" id="table-9730087b2db47e6072fd61a7ac553154"><table><thead><tr class="heading-row"><th class="default-col">Canada Rate to US Dollar</th><th class="default-col">'.$ratechange.'</th></tr></thead></table></div>'; 
    return $message;
    }

add_shortcode('ttorange_ratechange_table', 'ttorange_rate_table'); 

add_action("rest_api_init",function(){
    register_rest_route('YOUR_CUSTOM_ROUTE','setpricesxo',[
        'methods'=>'GET',
        'callback'=>'ttorange_setprice_api'
    ]);
});

add_action("rest_api_init",function(){
    register_rest_route('YOUR_CUSTOM_ROUTE','getpricesxo',[
        'methods'=>'GET',
        'callback'=>'ttorange_getprice_api'
    ]);
});

?>