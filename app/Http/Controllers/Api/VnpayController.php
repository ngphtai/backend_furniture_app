<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Redirect;

class VnpayController extends Controller
{
    public function pay(Request $request)
    {
        // bổ sung thông tin người dùng vào đây

        $request->validate(
            [
                'id' => 'required',
                'TotalPrice' => 'required',
            ],
            [
                'id.required' => 'id không được để trống',
                'TotalPrice.required' => 'TotalPrice không được để trống',
            ]
            );


        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = "S4SMEJK5"; //Website ID in VNPAY System
        $vnp_HashSecret = "EAORGNSLPZWOCEUQVZWUFEYIMQTOFTNR"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = " https://9f67-103-156-58-124.ngrok-free.app/api/vnpay-return";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $request->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng ';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->TotalPrice * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        //Billing
        $vnp_Bill_Mobile = '0949522102';
        $vnp_Bill_Email = "ngphtai.it@gmail.com";
        $fullName = trim("NGUYEN PHUOC TAI");
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address = "124 Lê Dương Thanh, Quận Hai Bà Trưng, Hà Nội";
        $vnp_Bill_City = "Hà Nội";
        $vnp_Bill_Country = 'VN';
        $vnp_Bill_State = '';
        // Invoice
        $vnp_Inv_Phone = "02437764668"; //input
        $vnp_Inv_Email = "pholv@vnpay.vn";
        $vnp_Inv_Customer = "Lê Văn Phổ";
        $vnp_Inv_Address = "22 Láng Hạ, Phường Láng Hạ, Quận Đống Đa, TP Hà Nội";
        $vnp_Inv_Company = "Công ty Cổ phần giải pháp Thanh toán Việt Nam";
        $vnp_Inv_Taxcode = "0102182292";
        $vnp_Inv_Type = "I";

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address" => $vnp_Bill_Address,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,
            "vnp_Inv_Phone" => $vnp_Inv_Phone,
            "vnp_Inv_Email" => $vnp_Inv_Email,
            "vnp_Inv_Customer" => $vnp_Inv_Customer,
            "vnp_Inv_Address" => $vnp_Inv_Address,
            "vnp_Inv_Company" => $vnp_Inv_Company,
            "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            }
        return response()->json($returnData);
    }

    public function vnpayReturn(Request $request)
    {

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');

        if ($vnp_ResponseCode == '00') {
            $invoice = Orders::find($vnp_TxnRef);
            //cập nhật dữ liệu đơn hàng

            // $invoice->IsPaid = true;
            // $invoice->save();
            return Redirect::to('{{DB_HOST}}:3000/orders/details/success' . $vnp_TxnRef);
        } else {
            $invoice = Orders::find($vnp_TxnRef);
            //cập nhật dữ liệu đơn hàng

            // $invoice->IsPaid = false;
            // $invoice->MethodPay = 1;
            // $invoice->save();
            return Redirect::to('{{DB_HOST}}:3000/orders/details/failed' )-> with('error', 'Thanh toán thất bại');
        }

        return Redirect::to('{{DB_HOST}}:3000/orders/details/' . $vnp_TxnRef);
    }
}
