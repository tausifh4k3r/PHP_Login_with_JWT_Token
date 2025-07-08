// Login
async function login(email, password) {
    const res = await fetch('/auth/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });
    const data = await res.json();
    if (res.ok) {
        localStorage.setItem('accessToken', data.accessToken);
    } else {
        alert(data.message);
    }
}

// Get Products
async function getProducts() {
    let token = localStorage.getItem('accessToken');
    let res = await fetch('/get_products.php', {
        headers: {
            'Authorization': 'Bearer ' + token
        }
    });

    if (res.status === 401) {
        // Try refresh
        const refreshRes = await fetch('/auth/refresh_token.php');
        const refreshData = await refreshRes.json();
        if (refreshRes.ok) {
            localStorage.setItem('accessToken', refreshData.accessToken);
            return getProducts(); // retry
        } else {
            alert("Session expired. Please login again.");
        }
    } else {
        const products = await res.json();
        console.log(products);
    }
}
