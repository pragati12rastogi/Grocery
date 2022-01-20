<?php 

    // include 'include/dbconfig.php';

    // $get_stock = $con->query('SELECT * FROM `inventory_stock`')->fetch_all(MYSQLI_ASSOC);
    
    // foreach($get_stock as $ind => $stock){
    //     $prod_qty = 10;
    //     $total_price = $stock['prod_price']*$prod_qty;
        

    //     if($stock['selling_price_wth_prft']==0){
    //         $profit_price = $stock['prod_price']+5;
    //         $total_profit_price = $profit_price*$prod_qty; 
    //     }else{
    //         $profit_price = $stock['selling_price_wth_prft'];
    //         $total_profit_price = $profit_price*$prod_qty;
    //     }
    //     $upd_inventory = $con->query('UPDATE `inventory_stock` SET `prod_quantity`='.$prod_qty.',`total_buying_price`="'.$total_price.'",`selling_price_wth_prft`="'.$profit_price.'",`total_price_with_profit`="'.$total_profit_price.'",`status`=1 WHERE id='.$stock['id']);
    //     $get_product = $con->query('UPDATE `product` SET `pgms`="'.$stock['unit'].'",`pprice`="'.$stock['prod_price'].'" WHERE pname="'.$stock['product_name'].'" and sid='.$stock['subcat_id'].' and cid='.$stock['cat_id'].'');
    // }
    

?>