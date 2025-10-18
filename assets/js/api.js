window.apiRequest = async function (fileName, params = {}, method = 'POST', responseType = 'json') {
    let url = `src/${fileName}.php`;
    const options = { method };

    if (method.toUpperCase() === 'GET' && Object.keys(params).length) {
        const queryString = new URLSearchParams(params).toString();
        url += '?' + queryString;
    } else if (method.toUpperCase() === 'POST') {
        options.body = new URLSearchParams(params);
        options.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
    }

    try {
        const response = await fetch(url, options);
        if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

        // Decide o tipo de retorno
        switch (responseType) {
            case 'text':
                return await response.text();
            case 'json':
                return await response.json();
            case 'blob':
                return await response.blob();
            default:
                return await response.text();
        }
    } catch (err) {
        console.error('Erro em apiRequest:', err);
        return { error: true, message: err.message };
    }
};
