<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Message;

class ExampleController extends Controller
{
   public function getUser()
   {
      $veri = Users::select('id', 'ogradisoyadi', 'tcno', 'mail')->take(5)->get();
      return response()->json([
         'data' => $veri,
         'toplam' => $veri->count(),
         'status' => 'success'
      ]);
   }
   public function KullaniciEkle(Request $request)
   {

      if (DB::table('users')->where('tcno', '=', $request->data['tcno'])->orWhere('mail', '=', $request->data['mail'])->count() > 0) {
         return response()->json([
            'status' => false,
            'message' => 'Bu kullanıcı zaten ekli'
         ], 200);
      } else {
         $users = new Users();
         $users->ogradisoyadi = $request->data['ogradisoyadi'];
         $users->tcno = $request->data['tcno'];
         $users->mail = $request->data['mail'];
         $users->password = Hash::make($request->data['password']);
         if ($users->save()) {
            return response()->json([
               'status' => true,
               'message' => 'User added successfully'
            ], 200);
         } else {
            return response()->json([
               'status' => false,
               'message' => 'User added failed'
            ], 200);
         }
      }
   }
   public function KullaniciSil(Request $request)
   {
      if (DB::table("users")->where('id', '=', $request->data['id'])->delete()) {
         return response()->json(
            [
               'status' => true,
               "message" => 'kullanıcı Silindi'
            ]
         );
      }
   }
   public function KullaniciDuzenle(Request $request)
   {
      $users = Users::where("id", "=", $request->data["id"])->first();
      if ($users) {
         $users->ogradisoyadi = $request->data['ogradisoyadi'];
         $users->tcno = $request->data['tcno'];
         $users->mail = $request->data['mail'];
         $users->password = Hash::make($request->data['password']);
         if ($users->save()) {
            return response()->json([
               'status' => true,
               'message' => 'User update successfully'
            ], 200);
         } else {
            return response()->json([
               'status' => false,
               'message' => 'User update failed'
            ], 200);
         }
      }

      return response()->json([
         'status' => false,
         'message' => 'Kullanıcı bulunamadı'
      ], 200);
   }
   public function Login(Request $request)
   {
      $gelendata = Users::select('password')->first();
      $kullaniciadi = $request->data["kullaniciAdi"];
      $gelensifre = $request->data["sifre"];
      $kakarsilastırma = Users::where('ogradisoyadi', '=', $kullaniciadi)->first();
      if (!$kakarsilastırma) {
         return response()->json(['status'=>false, 'message' => 'Login Fail, please check email id']);
      }
      if (!Hash::check($gelensifre, $gelendata->password)) {
         return response()->json(['status'=>false, 'message' => 'Login Fail, pls check password']);
      }
         return response()->json(['status'=>true,'message'=>'success']);
   }
}
