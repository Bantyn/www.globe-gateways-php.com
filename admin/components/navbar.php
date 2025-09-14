<style>
    .navbar-container {
    font-family: var(--main-font);
    padding: 1rem 4rem;
    background: var(--white-color);
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-bottom: 5vmin;
    position: relative;
}
.nav-menu {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}


.brand-logo{
    width: 3rem;
    height: auto;
    margin-right: 2rem;
}

.nav-left{
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.nav-left a {
    color: var(--black-color);
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.3rem;
    transition: 0.3s;  
}

.nav-left a:hover {
    background-color: var(--bg3-color);
    color: var(--white-color);
}
/* 
.nav-left a.active {
    background-color: var(--bg2-color);
    color: var(--black-color);
} */

/* Mobile Responsive */
@media(max-width: 768px){
    .navbar-container {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem 2rem;
    }
    .nav-left {
        flex-direction: column;
        width: 100%;
        margin-top: 0.5rem;
    }
    .nav-left a {
        width: 100%;
        text-align: left;
        padding: 0.75rem 1rem;
    }
}

.loader{
    height: 2.5px;
    width:100%;
    content: "";
    left:0;
    top: 100%;
    color: #000;
    animation: lineLoader 5s infinite linear;
    position: absolute;
    background-size: 400% 100%;
    z-index: 111;
    background-image: linear-gradient(to right,rgb(70, 255, 255),rgb(194, 194, 101),rgb(247, 129, 251));
}
.loader:nth-child(1){
    filter: blur(5px);
}
.loader:nth-child(2){
    filter: blur(10px);
}
@keyframes lineLoader{
    0%{
        background-position:180%;
    }
}
.logout-button,.logout-button button{
    background-color: crimson;
    color: var(--white-color);
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem 0.8rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
}
</style>
<nav class="navbar-container">
    <div class="nav-menu">
        <img src="../../assets/logo/gg--logo-black.png" alt="Logo" class="brand-logo">
        <div class="nav-left">
            <a href="dashboard.php?home=home" class="active">Home</a>
            <a href="dashboard.php?user=user">Users</a>
            <a href="dashboard.php?package=package">Packages</a>
            <a href="dashboard.php?reviews=reviews">Reviews</a>
            <a href="dashboard.php?payments=payments">Payments</a>
            <a href="dashboard.php?bookings=bookings">Bookings</a>
            <a href="dashboard.php?contacts=contacts">Contacts</a>

            <a href="?logout=true" name="logoutAdmin" class="logout-button"><button>Log-Out-admin</button></a>
            <?php
            if(isset($_REQUEST['logout'])) {
                setcookie("admin", "", time() - 10, "/");
                header("Location:../../client/page/login.php");
                exit();
            }
            ?>
        </div>
    </div>
    <div class="nav-loader">
        <div class="lineLoaderContainer" id="lineLoaderContainer">
            <div class="loader"></div>
            <div class="loader"></div>
            <div class="loader"></div>
        </div>
    </div>
</nav>