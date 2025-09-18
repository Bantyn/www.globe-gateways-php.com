document.addEventListener("DOMContentLoaded", () => {

    // ---------------------------
    // USERS CHART
    // ---------------------------
    const usersChartEl = document.getElementById("usersChart");
    if (usersChartEl) {
        axios.get("../api/get_users.php")
            .then(res => {
                const users = res.data;
                const usernames = users.map(u => u.username);
                const userCounts = users.map(u => u.user_id); // example metric

                new Chart(usersChartEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: usernames,
                        datasets: [{
                            label: "User Count",
                            data: userCounts,
                            backgroundColor: "rgba(54, 162, 235, 0.6)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true },
                            title: { display: true, text: "Users Overview" }
                        }
                    }
                });
            })
            .catch(err => console.error("Error loading users chart:", err));
    }

    // ---------------------------
    // PACKAGES CHART
    // ---------------------------
    const packagesChartEl = document.getElementById("packagesChart");
    if (packagesChartEl) {
        axios.get("../api/get_package.php")
            .then(res => {
                const packages = res.data;
                const titles = packages.map(p => p.title);
                const prices = packages.map(p => p.price);

                new Chart(packagesChartEl.getContext("2d"), {
                    type: "pie",
                    data: {
                        labels: titles,
                        datasets: [{
                            label: "Package Prices",
                            data: prices,
                            backgroundColor: [
                                "#FF6384",
                                "#36A2EB",
                                "#FFCE56",
                                "#4BC0C0",
                                "#9966FF"
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: { display: true, text: "Packages Price Distribution" }
                        }
                    }
                });
            })
            .catch(err => console.error("Error loading packages chart:", err));
    }

    // ---------------------------
    // REVIEWS CHART
    // ---------------------------
    const reviewsChartEl = document.getElementById("reviewsChart");
    if (reviewsChartEl) {
        axios.get("../api/get_reviews.php")
            .then(res => {
                const reviews = res.data;
                const ratings = reviews.map(r => r.rating);
                const counts = {};
                ratings.forEach(r => counts[r] = (counts[r] || 0) + 1);

                new Chart(reviewsChartEl.getContext("2d"), {
                    type: "line",
                    data: {
                        labels: Object.keys(counts),
                        datasets: [{
                            label: "Number of Reviews",
                            data: Object.values(counts),
                            fill: false,
                            borderColor: "rgba(255,99,132,1)",
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { title: { display: true, text: "Reviews Ratings Trend" } }
                    }
                });
            })
            .catch(err => console.error("Error loading reviews chart:", err));
    }

    // ---------------------------
    // PAYMENTS CHART
    // ---------------------------
    const paymentsChartEl = document.getElementById("paymentsChart");
    if (paymentsChartEl) {
        axios.get("../api/get_payments.php")
            .then(res => {
                const payments = res.data;
                const statuses = payments.map(p => p.status);
                const statusCounts = {};
                statuses.forEach(s => statusCounts[s] = (statusCounts[s] || 0) + 1);

                new Chart(paymentsChartEl.getContext("2d"), {
                    type: "doughnut",
                    data: {
                        labels: Object.keys(statusCounts),
                        datasets: [{
                            label: "Payments Status",
                            data: Object.values(statusCounts),
                            backgroundColor: ["#28a745", "#ffc107", "#dc3545"]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { title: { display: true, text: "Payments Status Overview" } }
                    }
                });
            })
            .catch(err => console.error("Error loading payments chart:", err));
    }

    // ---------------------------
    // GSAP Scroll Effects (Optional)
    // ---------------------------
    if (typeof gsap !== "undefined") {
        gsap.from(".title-container span", {
            y: -50,
            opacity: 0,
            stagger: 0.05,
            duration: 0.6
        });
    }

});
