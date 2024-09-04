const dataTimeline = () => {
    let data = [];
    let count = 0;
    let kimto = 500;
    for (let year = 2012; year <= 2024; year++) {
        const _data = {};
        _data['showDataTimeLine'] = count * kimto;
        _data['year'] = year;
        _data['listImages'] = [
            { url: '/static/uploads/sinhnhat/default.png' },
            { url: '/static/uploads/sinhnhat/default.png' },
            { url: '/static/uploads/sinhnhat/default.png' }
        ];
        _data['title'] = 'liprum';
        _data['content'] =
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ';
        data.push(_data);
        count++;
    }
    return data;
};

const dataEmployee = () => {
    let data = [];
    for (let i = 0; i < 190; i++) {
        const _data = {};
        _data['name'] = 'Gosu';
        _data['avatar'] = '/static/uploads/sinhnhat/default.png';
        data.push(_data);
    }
    return data;
};

export { dataTimeline, dataEmployee };
