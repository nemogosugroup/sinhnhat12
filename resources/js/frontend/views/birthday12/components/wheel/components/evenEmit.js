import mitt from 'mitt';
import CryptoJS from 'crypto-js';
const Emitter = mitt();
const encryptData = (data, secretKey, iv) => {
    const jsonData = JSON.stringify(data);
    const encrypted = CryptoJS.AES.encrypt(
        jsonData,
        CryptoJS.enc.Utf8.parse(secretKey),
        {
            iv: CryptoJS.enc.Utf8.parse(iv),
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        }
    ).toString();

    return encrypted;
};

export { Emitter, encryptData };
