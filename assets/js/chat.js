function fetchChat() {
    fetch('https://api.example.com/data')
        .then(response => {
            // Check if the request was successful (status code in 2xx range)
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the response body as JSON
        })
        .then(data => {
            console.log(data); // Process the fetched data
        })
        .catch(error => {
            console.error('Error fetching data:', error); // Handle any errors
        });
}