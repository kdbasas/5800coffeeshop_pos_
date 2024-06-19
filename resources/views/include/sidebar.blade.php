<div class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('img/5800 logo.png') }}" alt="Logo">
    </div>
    <h2 class="sidebar-title">ADMIN</h2>
    <a href="{{ route('admin.employee.index') }}" class="sidebar-link"><i class="fas fa-users"></i> Employees</a>
    <a href="{{ route('admin.product.index') }}" class="sidebar-link"><i class="fas fa-box"></i> Products</a>
    <a href="{{ route('admin.product_types.index') }}" class="sidebar-link"><i class="fas fa-tags"></i> Product Types</a>
    <a href="{{ route('admin.statistics') }}" class="sidebar-link"><i class="fas fa-chart-bar"></i> Statistics</a>
    <a href="{{ route('admin.gender.index') }}" class="sidebar-link"><i class="fas fa-venus-mars"></i> Genders</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-top: -10px; display: flex; justify-content: center;">
        @csrf
        <button type="submit" class="sidebar-link sidebar-logout" style="border: none; background: none; cursor: pointer;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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

    .sidebar a {
        padding: 20px; /* Increased padding for larger buttons */
        text-decoration: none;
        display: block;
        color: #fff;
        transition: all 0.3s ease;
        font-size: 1.2em; /* Increased font size */
        margin: 10px 0; /* Added margin for spacing */
    }

    .sidebar a:hover {
        background-color: #333;
    }

    .sidebar i {
        margin-right: 15px;
    }

    .sidebar-logout {
        margin-top: auto; /* Push the logout button to the bottom */
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
    padding: 20px;
    background-image: url('/img/coffee.png'); 
    background-size: cover;
    background-position: center;
    color: #fff;
    min-height: 100vh; /* Minimum height of 100% viewport height */
    width: calc(100% - 250px); /* Adjust width to fit content after sidebar */
    margin-left: 250px; /* Initial margin-left for sidebar */

    /* Ensure full height on smaller screens */
    @media (max-width: 768px) {
        margin-left: 0; /* Remove left margin on smaller screens */
        width: 100%; /* Full width on smaller screens */
    }
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

        .sidebar a {
            padding: 15px; /* Adjusted padding for mobile */
            font-size: 1.1em;
        }

        .content-area {
            margin-left: 0;
        }
    }
</style>
