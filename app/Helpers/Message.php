<?php 
namespace App\Helpers;

class Message {
    public function updateSuccess(){
        return 'Cập nhập dữ liệu thành công!';
    }
    public function createSuccess(){
        return 'Tạo dữ liệu thành công!';
    }
    public function deleteSuccess(){
        return 'Xoá dữ liệu thành công!';
    }
    public function updateError(){
        return 'Cập nhập dữ liệu thất bại!';
    }
    public function createError(){
        return 'Tạo dữ liệu thất bại!';
    }
    public function deleteError(){
        return 'Xoá dữ liệu thất bại!';
    }
    public function getSuccess(){
        return 'Lấy dữ liệu thành công!';
    }
    public function getError(){
        return 'Lấy dữ liệu thất bại!';
    }

    public function loginError(){
        return 'Tài khoản hoặc mật khẩu không đúng!';
    }
    public function emaiError(){
        return 'Địa chỉ email không chính xác!';
    }
    public function passError(){
        return 'Mật khẩu không chính xác!';
    }

    public function loginSuccess(){
        return 'Đăng nhập thành công!';
    }
    public function logoutSuccess(){
        return 'Đăng xuất thành công!';
    }
    public function dataExisted(){
        return 'Dữ liệu đã tồn tại!';
    }
    public function receiveQuestRewardSuccess(){
        return 'Nhận thưởng thành công!';
    }
    public function questNotExists(){
        return 'Nhiệm vụ không tồn tại!';
    }
    public function questNotComplete(){
        return 'Nhận thưởng không hợp lệ!';
    }
    public function inviteCodeSuccess(){
        return 'Nhập code thành công!';
    }
    public function inviteCodeInvalid($code){
        return "Code ".$code." không hợp lệ!";
    }
    public function inviteCodeExpired($code){
        return "Code ".$code." đã hết lượt sử dụng!";
    }
    public function inviteCodeUsed($code){
        return "Code ".$code." đã được sử dụng!";
    }
    public function inviteMaxQuest3(){
        return "Bạn đã xong nhiệm vụ nhập code!";
    }
}