<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Jeem Building Solutions</title>
    <link rel="stylesheet" href="style.css" media="all" />
	<style>
	@font-face {
  font-family: SourceSansPro;
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}


	</style>
  </head>
  <body>
    <header class="clearfix">
		<div id="logo">
			<!-- <img src="/public/JeemLogo.svg" alt="Image"> -->
			<!-- <img src="{{asset('storage/images/JeemLogo.svg')}}" alt="Image"> -->
			 <!-- <img src="{{ asset('storage/images/static/JeemLogo.svg')}}"> -->
			<!-- <img src="public/Jeem Logo.svg">  -->
		</div>
		<div id="company">
			<h2 class="name"> JEEM Building Solutions </h2>
		</div>
    </header>

    <main>
      	<div id="details" class="clearfix">
        	<div id="client">
          		<div class="to"><p lang="ar">: فاتورة للعميل</p>
				      </div>
				@php
					$shippingAddress = isset($order->orderShippingAddress)? json_decode($order->orderShippingAddress) : "";
				@endphp
				<div class="address"> {{ isset($shippingAddress->name)?$shippingAddress->name:"" }},
									  {{ isset($shippingAddress->address)?$shippingAddress->address:"" }},
									  {{ isset($shippingAddress->address1)?$shippingAddress->address1:"" }},
									  {{ isset($shippingAddress->city)?$shippingAddress->city:"" }},
									  {{ isset($shippingAddress->state)?$shippingAddress->state:"" }},
									  {{ isset($shippingAddress->country)?$shippingAddress->country:"" }}
				</div>
        	</div>
      	</div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="product_name">إسم المنتج</th>
            <th class="delivery_type">نوع التوصيل</th>
            <th class="qty">الكمية</th>
            <th class="unit_price">سعر الوحدة</th>
            <th class="tax">ضريبة القيمة المضافة</th>
            <th class="total">الإجمالي</th>
          </tr>
        </thead>
        <tbody>
			<?php $grandTotal = 0; ?>
			@foreach ($orderDetails as $key => $orderDetail)
				@if ($orderDetail->productName != null)
					<tr>
						<td>#</td>
						<td class="product_name"><h3>{{ $orderDetail->productName }}</h3></td>
						<td class="delivery_type">توصيل منزلي</td>
						<td class="qty">{{ $orderDetail->orderQuantity }}</td>
						<td class="unit">{{ $orderDetail->orderPrice }}</td>
						<td class="tax">{{ $orderDetail->orderTax }}</td>
						<td>{{ ($orderDetail->orderPrice * $orderDetail->orderQuantity) + 
							   ($orderDetail->orderTax * $orderDetail->orderQuantity) }}</td>
					</tr>
					<?php $grandTotal += ($orderDetail->orderPrice * $orderDetail->orderQuantity ) + ($orderDetail->orderTax * $orderDetail->orderQuantity) ?>	
				@endif
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th class="no">السعر النهائي</th>
				<th class="product_name"></th>
				<th class="delivery_type"></th>
				<th class="qty"></th>
				<th class="unit_price"></th>
				<th class="tax"></th>
				<th class="total">{{$grandTotal}}</th>
			</tr>
		</tfoot>	
      </table>
      <div id="thanks">!شكراً لكم</div>
      <div id="notices">
        <div>:ملاحظة</div>
        <div class="notice">طلبك سوف يتم توصيله بإسرع طريقة ممكنة والتوصيل سيتم بناء على إمكانيات التاجر</div>
      </div>
    </main>
    <footer>
    هذه الفاتورة الكترونية وتحتاج الى تصديق من قبل التاجر أو الموقع
    </footer>
  </body>
</html>