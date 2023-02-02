<?php
namespace App\constants;

interface OrderStatus{

    const Order_cancelled=0;
    const Order_pending=1;
    const Order_accepted=2;
    const Order_rejected=3;
    const Order_delivered=4;
    
}