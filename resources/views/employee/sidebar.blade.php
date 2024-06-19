<div class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('img/5800 logo.png') }}" alt="Logo">
    </div>
    <h2 class="sidebar-title">CASHIER</h2>
    <a href="{{ route('employee.sell.index') }}" class="sidebar-link"><i class="fas fa-shopping-cart"></i>Cart</a>
    <form action="{{ route('logout') }}" method="post" class="sidebar-form">
        @csrf
        <button type="submit" class="sidebar-link sidebar-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #F4CD81; /* Background color for the entire page */
    }

    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #37251b;
        color: #fff;
        padding-top: 20px;
        overflow-y: auto;
        text-align: center;
    }

    .sidebar-logo {
        margin-bottom: 20px;
    }

    .sidebar-logo img {
        max-width: 80%;
        max-height: 150px;
        height: auto;
        width: auto;
    }

    .sidebar-title {
        color: #fff;
        font-size: 1.5em;
        font-family: 'Montserrat', sans-serif; /* Corrected font family name */
        margin-bottom: 30px;
        display: block;
        width: 100%; /* Ensure the title is wide */
    }

    .sidebar-link {
        padding: 20px; /* Increased padding for larger buttons */
        text-decoration: none;
        display: block;
        color: #fff;
        transition: all 0.3s ease;
        font-size: 1.2em; /* Increased font size */
        margin: 10px 0; /* Added margin for spacing */
    }

    .sidebar-link:hover {
        background-color: #333;
    }

    .sidebar i {
        margin-right: 15px;
    }

    .sidebar-form {
        margin-top: auto; /* Push the logout button to the bottom */
        display: flex;
        justify-content: center;
    }

    .sidebar button.sidebar-logout {
        padding: 20px; /* Adjusted padding for larger button */
        text-decoration: none;
        display: block;
        color: #fff; /* White color */
        background-color: transparent; /* Transparent background */
        border: none;
        transition: all 0.3s ease;
        font-size: 1.2em; /* Increased font size */
        margin: 10px 0; /* Added margin for spacing */
    }

    .sidebar button.sidebar-logout:hover {
        background-color: rgba(255, 255, 255, 0.1); /* Light background color on hover */
    }

    .content-area {
        margin-left: 250px;
        padding: 20px;
        background-image: url('/img/coffee.png'); 
        background-size: cover;
        background-position: center;
        color: #fff;
        height: 100vh;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            padding-top: 0;
            position: relative;
        }

        .sidebar h2 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .sidebar-link {
            padding: 15px; /* Adjusted padding for mobile */
            font-size: 1.1em;
        }

        .content-area {
            margin-left: 0;
        }
    }
</style>
