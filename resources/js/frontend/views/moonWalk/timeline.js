import dataJsonTimeline from './dataTimeline';

const dataTimeline = () => {
    const data = [];
    const silk = 500;

    // Lặp qua các năm từ 2011 đến 2024
    for (let count = 0, year = 2011; year <= 2024; year++, count++) {
        const mileStoneSilk = count * silk;

        // Lọc các phần tử có năm phù hợp từ dataJsonTimeline
        const filteredData = dataJsonTimeline.filter(
            ({ date }) => date.split('/').pop() == year
        );

        // Tạo danh sách content và listImages từ các phần tử đã lọc
        const content = filteredData.map(({ date, content, image }) => {
            let images = [];
            if (Array.isArray(image) && image.length > 0) {
                images = image.map((url) => ({
                    url,
                    alt: date + ' ' + content
                }));
            }
            return { date, content, images };
        });

        // Tạo đối tượng dữ liệu cho từng năm
        const _data = {
            mileStoneSilk,
            year,
            listImages: content.flatMap((c) => c.images), // Lấy tất cả các images từ content
            content: content.map((c) => ({ date: c.date, content: c.content }))
        };

        data.push(_data);
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
        },
        {
            name: 'Studio ',
            data: 'DUO',
            value: 'duo'
        }
    ];
    return data;
};

export { dataTimeline, dataDepartMent, dataJsonTimeline };
