const dataTimeline = () => {
    let data = [];
    let count = 0;
    let silk = 500;
    for (let year = 2012; year <= 2024; year++) {
        const _data = {};
        _data['mileStoneSilk'] = count * silk;
        _data['year'] = year;
        _data['listImages'] = [
            { url: '/static/uploads/sinhnhat/banner-wweb.png' },
            { url: '/static/uploads/sinhnhat/banner-wweb.png' },
            { url: '/static/uploads/sinhnhat/banner-wweb.png' }
        ];
        _data['content'] =
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ';
        data.push(_data);
        count++;
    }
    return data;
};

const dataDepartMent = () => {
    let data = [
        {
            name: 'Trung Tâm',
            data: 'NEMO',
            value: 'nemo'
        },
        {
            name: 'Trung Tâm',
            data: 'IRC',
            value: 'irc'
        },
        {
            name: 'Trung Tâm',
            data: 'TCKT',
            value: 'tckt'
        },
        {
            name: 'Trung Tâm',
            data: 'GAMO',
            value: 'gamo'
        },
        {
            name: 'Trung Tâm',
            data: 'GOTA',
            value: 'gota'
        },
        {
            name: 'Bộ phận',
            data: 'Tổ trợ lý',
            value: 'totroly'
        },
        {
            name: 'Trung Tâm',
            data: 'GBC',
            value: 'gbc'
        },
        {
            name: 'Trung Tâm',
            data: 'CMC',
            value: 'cmc'
        },
        {
            name: 'Trung Tâm',
            data: 'ITC',
            value: 'itc'
        },
        {
            name: 'Bộ Phận',
            data: 'Design',
            value: 'design'
        },
        {
            name: 'Bộ Phận',
            data: 'HCNS',
            value: 'hcns'
        },
        {
            name: 'Bộ Phận',
            data: 'KTHT',
            value: 'ktht'
        }
    ];
    return data;
};

export { dataTimeline, dataDepartMent };
