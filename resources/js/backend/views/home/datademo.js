import images from "@/assets/images/map/mapdemo.png";
const dataDemo = () => {
    let count = 30;
    let data = [];
    for (let index = 0; index < count; index++) {
        let id = index + 1;
        let item = {};
        item['id'] = id;
        item['images'] = images;
        item['title'] = 'Tầng 3 tòa nhà HH2 Bắc Hà, Số 15 Đường Tố Hữu, Phường Nhân Chính, Quận Thanh Xuân, TP. Hà Nội, Việt Nam';
        item['lat'] = '20.8396855';
        item['long'] = '106.705651';
        item['manager'] = 'Gosu';
        data.push(item);
    }
    return data;
};

export {
    dataDemo
};