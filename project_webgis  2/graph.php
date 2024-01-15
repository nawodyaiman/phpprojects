<?php

$connection = mysqli_connect("localhost", "root", "");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


?>

<!DOCTYPE HTML>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Tutorial</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    
    <style>

#map{
            height: 100vh;
            width: 70%;
            
            
            position: relative;
            z-index: 1;
            padding-left: 5px;
            
        }


        .info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}
.info h4 {
    margin: 0 0 5px;
    color: #777;
}

.legend {
    line-height: 18px;
    color: #555;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
}

        /* Define styles for the transparent box */
        .chart-container-wrapper {
        width: 450px;
        height: 200px;
        background-color: rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        margin-top: 20px;
        padding: 10px;
        position: fixed; /* Fixed position to stay in view */
        top: 20px; /* Adjust as needed */
        left: 20px; /* Adjust as needed */
        z-index: 1; /* Higher z-index to overlay on the map */
        display: block; /* Show the chart by default */
    }
    body {
    /* Set the background image URL */
    background-size: cover; /* Cover the entire viewport */
    background-color: #7EC8E3;
    margin: 0; /* Remove default margin */
    display: flex;
    overflow: auto; /* Enable scrolling when content overflows */
}


        .dashboard {
        width: 400px;
        height: auto;
        background-color: floralwhite;
        border: 1px solid #ccc;
        margin-top: 20px;
        padding: 10px;
        position: absolute; /* Fixed position to stay in view */
        top: 20px; /* Adjust as needed */
        right: 20px; /* Adjust as needed */
        z-index: 2; /* Higher z-index to overlay on the map */
        text-align: center;
        overflow: auto; 
    }

        .district {
            cursor: pointer;
            font-weight: bold;
            padding: 8px 12px; /* Adjust padding as needed */
            margin: 5px; /* Adjust margin as needed */
            border: 1px solid #ccc;
            border-radius: 5px; /* Add border radius for a rounded appearance */
            color: rosybrown;
            background-color: rgba(0, 12, 0, 1);
        }

        .district:hover {
            background-color: #f0f0f0; /* Change the background color on hover */
        }

        .categories {
            display: none;
            padding-left: 20px; /* Adjust as needed for indentation */
        }

        .category-radio {
            margin-right: 10px; /* Adjust as needed for spacing */
		}

		iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            border: none;
            opacity: 0.5; /* Set the desired opacity value */
            z-index: -1; /* Set a lower z-index value to position it behind other content */
        }
		.content {
            position: relative;
            z-index: 1;
            padding: 20px;
            color: #fff;
        }
        form {
        display: flex;
        flex-direction: column; /* Align items in a column */
        max-width: 300px; /* Adjust as needed */
        margin: auto; /* Center the form horizontally */
    }

    .category-radio {
        margin-bottom: 10px; /* Adjust as needed for spacing between radio buttons */
    }


.formBlock {
    max-width: 300px;
    background-color: #FFF;
    border: 1px solid #ddd;
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 10px;
    z-index: 999;
    box-shadow: 0 1px 5px rgba(0,0,0,0.65);
    border-radius: 5px;
    width: 100%;
}

.leaflet-top .leaflet-control {
    margin-top: 180px;
}

.input {
    padding: 10px;
    width: 100%;
    border: 1px solid #ddd;
    font-size: 15px;
    border-radius: 3px;
}

#form {
    padding: 0;
    margin: 0;
}
input:nth-child(1) {
    margin-bottom: 10px;
}

     
</style>

</head>

<body>


<div id="map"></div>

    <div class="chart-container-wrapper" id="chart-container-wrapper">
	<div id="chartContainer" style="height: 100%; width: 100%;"></div>
    </div>

    <div class="dashboard">
        <div id="districtMenu">
            <div class="district" onclick="toggleCategories('district1')">Ampara</div>
            <div class="categories" id="district1" >
            <form method="post" action="script.php">
                <div>
                    <label for="ampara_forests">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_forest" id="ampara_forest" onclick="showChart()" > Ampara Forests
                    </label>
                </div>
                <div class="order-2">
                    <label for="ampara_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_water" id="ampara_water" onclick="showChart()"> Water Surfaces
                    </label>
                </div>

                <div>
                    <label for="ampara_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_cropland" id="ampara_cropland" onclick="showChart()"> Ampara Cropland
                    </label>
                </div>
                <div>
                    <label for="ampara_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_urban" id="ampara_urban" onclick="showChart()"> Ampara Urban
                    </label>
                </div>
                <div>
                    <label for="ampara_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_pasture" id="ampara_pasture" onclick="showChart()"> Ampara Pasture
                    </label>
                </div>
                <div>
                    <label for="ampara_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_shrubland" id="ampara_shrubland" onclick="showChart()"> Ampara Shrubland
                    </label>
                </div>
                <div>
                    <label for="ampara_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="ampara_no_vegetation" id="ampara_no_vegetation" onclick="showChart()"> No vegetation
                    </label>
                </div>
      

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district2')">Anuradhapura</div>
            <div class="categories" id="district2" >
            <form method="post" action="script.php">
                <div>
                    <label for="anuradhapura_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_forest" id="anuradhapura_forest" onclick="showChart()" > Forests
                    </label>
                </div>
                <div class="order-2">
                    <label for="anuradhapura_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_water" id="anuradhapura_water" onclick="showChart()"> Water Surfaces
                    </label>
                </div>

                <div>
                    <label for="anuradhapura_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_cropland" id="anuradhapura_cropland" onclick="showChart()">Cropland
                    </label>
                </div>
                <div>
                    <label for="anuradhapura_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_urban" id="anuradhapura_urban" onclick="showChart()">  Urban Surface
                    </label>
                </div>
                <div>
                    <label for="anuradhapura_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_pasture" id="anuradhapura_pasture" onclick="showChart()">Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="anuradhapura_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_shrubland" id="anuradhapura_shrubland" onclick="showChart()"> Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="anuradhapura_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="anuradhapura_no_vegetation" id="anuradhapura_no_vegetation" onclick="showChart()"> No vegetation
                    </label>
                </div>
      

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district3')">Badulla</div>
            <div class="categories" id="district3" >
            <form method="post" action="script.php">
                <div>
                    <label for="badulla_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_cropland" id="badulla_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="badulla_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_forest" id="badulla_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="badulla_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_no_vegetation" id="badulla_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="badulla_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_pasture" id="badulla_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="badulla_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_shrubland" id="badulla_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="badulla_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_urban" id="badulla_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="badulla_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="badulla_water" id="badulla_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district4')">Batticalao</div>
            <div class="categories" id="district4" >
            <form method="post" action="script.php">
                <div>
                    <label for="batticalao_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_cropland" id="batticalao_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="batticalao_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_forest" id="batticalao_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="batticalao_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_no_vegetation" id="batticalao_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="batticalao_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_pasture" id="batticalao_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="batticalao_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_shrubland" id="batticalao_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="batticalao_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_urban" id="batticalao_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="batticalao_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="batticalao_water" id="batticalao_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district5')">Colombo</div>
            <div class="categories" id="district5" >
            <form method="post" action="script.php">
                <div>
                    <label for="colombo_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_cropland" id="colombo_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="colombo_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_forest" id="colombo_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="colombo_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_no_vegetation" id="colombo_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="colombo_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_pasture" id="colombo_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="colombo_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_shrubland" id="colombo_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="colombo_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_urban" id="colombo_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="colombo_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="colombo_water" id="colombo_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district6')">Galle</div>
            <div class="categories" id="district6" >
            <form method="post" action="script.php">
                <div>
                    <label for="galle_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_cropland" id="galle_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="galle_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_forest" id="galle_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="galle_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_no_vegetation" id="galle_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="galle_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_pasture" id="galle_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="galle_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_shrubland" id="galle_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="galle_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_urban" id="galle_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="galle_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="galle_water" id="galle_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district7')">Gampaha</div>
            <div class="categories" id="district7" >
            <form method="post" action="script.php">
                <div>
                    <label for="gampaha_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_cropland" id="gampaha_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="gampaha_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_forest" id="gampaha_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="gampaha_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_no_vegetation" id="gampaha_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="gampaha_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_pasture" id="gampaha_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="gampaha_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_shrubland" id="gampaha_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="gampaha_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_urban" id="gampaha_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="gampaha_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="gampaha_water" id="gampaha_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district8')">Hambanthota</div>
            <div class="categories" id="district8" >
            <form method="post" action="script.php">
                <div>
                    <label for="hambanthota_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_cropland" id="hambanthota_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="hambanthota_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_forest" id="hambanthota_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="hambanthota_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_no_vegetation" id="hambanthota_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="hambanthota_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_pasture" id="hambanthota_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="hambanthota_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_shrubland" id="hambanthota_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="hambanthota_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_urban" id="hambanthota_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="hambanthota_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="hambanthota_water" id="hambanthota_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district9')">Jaffna</div>
            <div class="categories" id="district9" >
            <form method="post" action="script.php">
                <div>
                    <label for="jaffna_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_cropland" id="jaffna_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="jaffna_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_forest" id="jaffna_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="jaffna_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_no_vegetation" id="jaffna_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="jaffna_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_pasture" id="jaffna_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="jaffna_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_shrubland" id="jaffna_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="jaffna_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_urban" id="jaffna_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="jaffna_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="jaffna_water" id="jaffna_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district10')">Kaluthara</div>
            <div class="categories" id="district10" >
            <form method="post" action="script.php">
                <div>
                    <label for="kaluthara_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_cropland" id="kaluthara_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="kaluthara_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_forest" id="kaluthara_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="kaluthara_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_no_vegetation" id="kaluthara_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="kaluthara_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_pasture" id="kaluthara_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="kaluthara_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_shrubland" id="kaluthara_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="kaluthara_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_urban" id="kaluthara_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="kaluthara_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="kaluthara_water" id="kaluthara_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district11')">Kandy</div>
            <div class="categories" id="district11" >
            <form method="post" action="script.php">
                <div>
                    <label for="kandy_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_cropland" id="kandy_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="kandy_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_forest" id="kandy_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="kandy_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_no_vegetation" id="kandy_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="kandy_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_pasture" id="kandy_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="kandy_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_shrubland" id="kandy_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="kandy_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_urban" id="kandy_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="kandy_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="kandy_water" id="kandy_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district12')">Kegalle</div>
            <div class="categories" id="district12" >
            <form method="post" action="script.php">
                <div>
                    <label for="kegalle_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_cropland" id="kegalle_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="kegalle_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_forest" id="kegalle_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="kegalle_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_no_vegetation" id="kegalle_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="kegalle_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_pasture" id="kegalle_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="kegalle_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_shrubland" id="kegalle_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="kegalle_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_urban" id="kegalle_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="kegalle_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="kegalle_water" id="kegalle_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district13')">Kilinochchi</div>
            <div class="categories" id="district13" >
            <form method="post" action="script.php">
                <div>
                    <label for="kilinochchi_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_cropland" id="kilinochchi_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="kilinochchi_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_forest" id="kilinochchi_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="kilinochchi_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_no_vegetation" id="kilinochchi_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="kilinochchi_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_pasture" id="kilinochchi_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="kilinochchi_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_shrubland" id="kilinochchi_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="kilinochchi_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_urban" id="kilinochchi_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="kilinochchi_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="kilinochchi_water" id="kilinochchi_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district14')">Kurunegala</div>
            <div class="categories" id="district14" >
            <form method="post" action="script.php">
                <div>
                    <label for="kurunegala_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_cropland" id="kurunegala_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="kurunegala_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_forest" id="kurunegala_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="kurunegala_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_no_vegetation" id="kurunegala_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="kurunegala_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_pasture" id="kurunegala_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="kurunegala_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_shrubland" id="kurunegala_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="kurunegala_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_urban" id="kurunegala_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="kurunegala_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="kurunegala_water" id="kurunegala_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district15')">Mannar</div>
            <div class="categories" id="district15" >
            <form method="post" action="script.php">
                <div>
                    <label for="mannar_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_cropland" id="mannar_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="mannar_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_forest" id="mannar_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="mannar_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_no_vegetation" id="mannar_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="mannar_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_pasture" id="mannar_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="mannar_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_shrubland" id="mannar_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="mannar_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_urban" id="mannar_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="mannar_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="mannar_water" id="mannar_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district16')">Mathale</div>
            <div class="categories" id="district16" >
            <form method="post" action="script.php">
                <div>
                    <label for="mathale_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_cropland" id="mathale_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="mathale_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_forest" id="mathale_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="mathale_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_no_vegetation" id="mathale_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="mathale_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_pasture" id="mathale_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="mathale_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_shrubland" id="mathale_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="mathale_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_urban" id="mathale_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="mathale_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathale_water" id="mathale_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district17')">Mathara</div>
            <div class="categories" id="district17" >
            <form method="post" action="script.php">
                <div>
                    <label for="mathara_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_cropland" id="mathara_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="mathara_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_forest" id="mathara_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="mathara_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_no_vegetation" id="mathara_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="mathara_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_pasture" id="mathara_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="mathara_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_shrubland" id="mathara_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="mathara_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_urban" id="mathara_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="mathara_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="mathara_water" id="mathara_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district18')">Monaragala</div>
            <div class="categories" id="district18" >
            <form method="post" action="script.php">
                <div>
                    <label for="monaragala_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_cropland" id="monaragala_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="monaragala_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_forest" id="monaragala_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="monaragala_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_no_vegetation" id="monaragala_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="monaragala_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_pasture" id="monaragala_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="monaragala_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_shrubland" id="monaragala_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="monaragala_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_urban" id="monaragala_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="monaragala_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="monaragala_water" id="monaragala_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district19')">Mulativ</div>
            <div class="categories" id="district19" >
            <form method="post" action="script.php">
                <div>
                    <label for="mulativ_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_cropland" id="mulativ_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="mulativ_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_forest" id="mulativ_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="mulativ_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_no_vegetation" id="mulativ_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="mulativ_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_pasture" id="mulativ_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="mulativ_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_shrubland" id="mulativ_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="mulativ_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_urban" id="mulativ_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="mulativ_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="mulativ_water" id="mulativ_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district20')">Nuwaraeliya</div>
            <div class="categories" id="district20" >
            <form method="post" action="script.php">
                <div>
                    <label for="nuwaraeliya_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_cropland" id="nuwaraeliya_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="nuwaraeliya_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_forest" id="nuwaraeliya_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="nuwaraeliya_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_no_vegetation" id="nuwaraeliya_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="nuwaraeliya_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_pasture" id="nuwaraeliya_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="nuwaraeliya_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_shrubland" id="nuwaraeliya_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="nuwaraeliya_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_urban" id="nuwaraeliya_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="nuwaraeliya_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="nuwaraeliya_water" id="nuwaraeliya_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district21')">Polonnaruwa</div>
            <div class="categories" id="district21" >
            <form method="post" action="script.php">
                <div>
                    <label for="polonnaruwa_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_cropland" id="polonnaruwa_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="polonnaruwa_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_forest" id="polonnaruwa_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="polonnaruwa_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_no_vegetation" id="polonnaruwa_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="polonnaruwa_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_pasture" id="polonnaruwa_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="polonnaruwa_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_shrubland" id="polonnaruwa_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="polonnaruwa_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_urban" id="polonnaruwa_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="polonnaruwa_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="polonnaruwa_water" id="polonnaruwa_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district22')">Puttalam</div>
            <div class="categories" id="district22" >
            <form method="post" action="script.php">
                <div>
                    <label for="puttalam_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_cropland" id="puttalam_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="puttalam_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_forest" id="puttalam_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="puttalam_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_no_vegetation" id="puttalam_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="puttalam_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_pasture" id="puttalam_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="puttalam_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_shrubland" id="puttalam_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="puttalam_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_urban" id="puttalam_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="puttalam_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="puttalam_water" id="puttalam_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district23')">Rathnapura</div>
            <div class="categories" id="district23" >
            <form method="post" action="script.php">
                <div>
                    <label for="rathnapura_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_cropland" id="rathnapura_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="rathnapura_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_forest" id="rathnapura_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="rathnapura_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_no_vegetation" id="rathnapura_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="rathnapura_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_pasture" id="rathnapura_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="rathnapura_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_shrubland" id="rathnapura_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="rathnapura_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_urban" id="rathnapura_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="rathnapura_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="rathnapura_water" id="rathnapura_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>

        <div class="district" onclick="toggleCategories('district24')">Trincomalee</div>
            <div class="categories" id="district24" >
            <form method="post" action="script.php">
                <div>
                    <label for="trincomalee_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_cropland" id="trincomalee_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="trincomalee_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_forest" id="trincomalee_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="trincomalee_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_no_vegetation" id="trincomalee_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="trincomalee_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_pasture" id="trincomalee_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="trincomalee_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_shrubland" id="trincomalee_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="trincomalee_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_urban" id="trincomalee_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="trincomalee_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="trincomalee_water" id="trincomalee_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


        <div class="district" onclick="toggleCategories('district25')">Vavuniya</div>
            <div class="categories" id="district25" >
            <form method="post" action="script.php">
                <div>
                    <label for="vavuniya_cropland">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_cropland" id="vavuniya_cropland" onclick="showChart()" > Cropland
                    </label>
                </div>
                <div class="order-2">
                    <label for="vavuniya_forest">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_forest" id="vavuniya_forest" onclick="showChart()"> Forest Surface
                    </label>
                </div>

                <div>
                    <label for="vavuniya_no_vegetation">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_no_vegetation" id="vavuniya_no_vegetation" onclick="showChart()">No Vegetation
                    </label>
                </div>
                <div>
                    <label for="vavuniya_pasture">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_pasture" id="vavuniya_pasture" onclick="showChart()">  Pasture Surface
                    </label>
                </div>
                <div>
                    <label for="vavuniya_shrubland">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_shrubland" id="vavuniya_shrubland" onclick="showChart()">Shrubland Surface
                    </label>
                </div>
                <div>
                    <label for="vavuniya_urban">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_urban" id="vavuniya_urban" onclick="showChart()"> Urban Surface
                    </label>
                </div>
                <div>
                    <label for="vavuniya_water">
                        <input type="radio" class="category-radio" name="selectedTable" value="vavuniya_water" id="vavuniya_water" onclick="showChart()"> Water Surface
                    </label>
                </div>
        

                <input type="submit" style="display: none;"> <!-- Hidden submit button -->
            </form>
        </div>


       


        






        


        </div>
    </div>

    <script src="graph.js"></script>
    <script>
        function toggleCategories(districtId) {
            var allCategories = document.querySelectorAll('.categories');

            // Hide all categories
            allCategories.forEach(function (category) {
                category.style.display = 'none';
            });

            // Show the categories of the clicked district
            var categories = document.getElementById(districtId);
            if (categories.style.display === 'none') {
                categories.style.display = 'block';
            } else {
                categories.style.display = 'none';
            }

            // Hide the chart when toggling categories
            var chartContainer = document.getElementById('chart-container-wrapper');
            chartContainer.style.display = 'none';
        }

        function showChart() {
    // Get the selected radio button value
    var selectedTable = document.querySelector('input[name="selectedTable"]:checked').value;

    // Construct the SQL query based on the selected table
    var sqlQuery = "SELECT Year, Amount FROM " + selectedTable;

    // Fetch data from the selected table
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'script.php?sqlQuery=' + encodeURIComponent(sqlQuery), true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            var jsonData = JSON.parse(xhr.responseText);

            // Show the chart only when data is available
            if (jsonData.length > 0) {
                var chartContainer = document.getElementById('chart-container-wrapper');
                chartContainer.style.display = 'block';

                // Create a new CanvasJS chart with the updated data
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Variation from 1900 - 2019"
                    },
                    axisY: {
                        title: "Amount",
                        includeZero: true,
                        prefix: "",
                        suffix: ""
                    },
                    data: [{
                        type: "bar",
                        yValueFormatString: "",
                        indexLabelPlacement: "inside",
                        indexLabelFontWeight: "bolder",
                        indexLabelFontColor: "white",
                        barWidth: 20,
                        color: "steelblue",
                        dataPoints: jsonData
                    }],
                    backgroundColor: "rgba(0, 0, 0, 0)"
                });

                // Render the chart
                chart.render();
            } else {
                // Hide the chart container if no data is available
                var chartContainer = document.getElementById('chart-container-wrapper');
                chartContainer.style.display = 'none';
            }
        }
    };

    // Send the request
    xhr.send();
}



function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_water').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });


    function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_forest').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }

        
    });


    function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }

        
    });

    function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }

        

        
    });

    function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }

        
    });

    function highlightAmparaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(amparaD.getBounds());

        // Highlight the Ampara GeoJSON layer
        amparaD.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('ampara_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightAmparaArea();
        } else {
            // Reset styles if the radio button is unchecked
            amparaD.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }

        

        
    });








    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_forest').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_water').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightAnuradhapuraArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(anuradhapuras.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('anuradhapura_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightAnuradhapuraArea();
        } else {
            // Reset styles if the radio button is unchecked
            anuradhapuras.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });


    

    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_forest').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_water').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        anuradhapuras.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBadullaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(badullas.getBounds());

        // Highlight the Ampara GeoJSON layer
        badullas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('badulla_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightBadullaArea();
        } else {
            // Reset styles if the radio button is unchecked
            badullas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });



    //batticaloa

    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_water').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightBatticaloaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(batticalaos.getBounds());

        // Highlight the Ampara GeoJSON layer
        batticalaos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('batticalao_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightBatticaloaArea();
        } else {
            // Reset styles if the radio button is unchecked
            batticalaos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    //colombo



     function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_water').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightColomboArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(colombos.getBounds());

        // Highlight the Ampara GeoJSON layer
        colombos.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('colombo_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightColomboArea();
        } else {
            // Reset styles if the radio button is unchecked
            colombos.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });


    //galle


    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_water').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGalleArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(galles.getBounds());

        // Highlight the Ampara GeoJSON layer
        galles.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('galle_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightGalleArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });


    //Gampaha

    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_water').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            galles.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightGampahaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(gampahas.getBounds());

        // Highlight the Ampara GeoJSON layer
        gampahas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('gampaha_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightGampahaArea();
        } else {
            // Reset styles if the radio button is unchecked
            gampahas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    //Hambanthota


    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_water').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightHambanthotaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(hambantotas.getBounds());

        // Highlight the Ampara GeoJSON layer
        hambantotas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('hambanthota_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightHambanthotaArea();
        } else {
            // Reset styles if the radio button is unchecked
            hambantotas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    // Jaffna


    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_water').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightJaffnaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(jaffnas.getBounds());

        // Highlight the Ampara GeoJSON layer
        jaffnas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('jaffna_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightJaffnaArea();
        } else {
            // Reset styles if the radio button is unchecked
            jaffnas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    // kaluthara


    
    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    
    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_water').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });
    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_cropland').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_urban').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_pasture').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_shrubland').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });

    function highlightKalutharaArea() {
        // Zoom to the bounds of the Ampara GeoJSON layer
        map.fitBounds(kalutharas.getBounds());

        // Highlight the Ampara GeoJSON layer
        kalutharas.setStyle({
            weight: 5,
            color: 'blue',
            fillOpacity: 0.5
        });
    }

    // Event listener for the radio button
    document.getElementById('kaluthara_no_vegetation').addEventListener('change', function () {
        if (this.checked) {
            highlightKalutharaArea();
        } else {
            // Reset styles if the radio button is unchecked
            kalutharas.setStyle({
                weight: 2,
                color: 'green',
                fillOpacity: 1
            });
        }
    });











    

legend.addTo(map);






	
</script>
    
</body>

</html>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="./data/line.js"></script>
<script src="./data/point.js"></script>
<script src="./data/polygon.js"></script>
<script src="./data/nepaldata.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="./data/usstates.js"></script>
<script src="./data/ampara.js"></script>
<script src="./data/anuradapura.js"></script>
<script src="./data/badulla .js"></script>
<script src="./data/batticalao .js"></script>
<script src="./data/colombo .js"></script>
<script src="./data/colombo .js"></script>
<script src="./data/galle .js"></script>
<script src="./data/gampaha .js"></script>
<script src="./data/hambantota .js"></script>
<script src="./data/jaffna .js"></script>
<script src="./data/kalutara .js"></script>
<script src="./data/kandy .js"></script>
<script src="./data/kegalle .js"></script>
<script src="./data/kilinochchi .js"></script>
<script src="./data/kurunegala .js"></script>
<script src="./data/mannar .js"></script>
<script src="./data/mathale .js"></script>
<script src="./data/mathara .js"></script>
<script src="./data/moneragala .js"></script>
<script src="./data/mulathiu .js"></script>
<script src="./data/nuwaraeliya .js"></script>
<script src="./data/polonnaruwa.js"></script>
<script src="./data/puttalam .js"></script>
<script src="./data/rathnapura .js"></script>
<script src="./data/trinco .js"></script>
<script src="./data/vavuniya .js"></script>


<script>

    /*===================================================
                      OSM  LAYER               
===================================================*/

    var map = L.map('map').setView([7.8731,80.7718], 8);
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
osm.addTo(map);

/*===================================================
                      MARKER               
===================================================*/

var singleMarker = L.marker([28.25255,83.97669]);
singleMarker.addTo(map);
var popup = singleMarker.bindPopup('This is a popup')
popup.addTo(map);

/*===================================================
                     TILE LAYER               
===================================================*/

var CartoDB_DarkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
subdomains: 'abcd',
	maxZoom: 19
});
CartoDB_DarkMatter.addTo(map);

// Google Map Layer

googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
 });
 googleStreets.addTo(map);

 // Satelite Layer
googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
   maxZoom: 20,
   subdomains:['mt0','mt1','mt2','mt3']
 });
googleSat.addTo(map);

var Stamen_Watercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
 attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
subdomains: 'abcd',
minZoom: 1,
maxZoom: 16,
ext: 'jpg'
});
Stamen_Watercolor.addTo(map);


/*===================================================
                      GEOJSON               
===================================================*/

var linedata = L.geoJSON(lineJSON).addTo(map);
var pointdata = L.geoJSON(pointJSON).addTo(map);
// var nepalData = L.geoJSON(nepaldataa).addTo(map);
var amparaD = L.geoJSON(ampara).addTo(map);
var anuradhapuras = L.geoJSON(anuradhapuraD).addTo(map);
var badullas = L.geoJSON(badullaD).addTo(map);
var batticalaos = L.geoJSON(batticalaoD).addTo(map);
var colombos = L.geoJSON(colomboD).addTo(map);
var galles = L.geoJSON(galleD).addTo(map);
var gampahas = L.geoJSON(gampahaD).addTo(map);
var hambantotas = L.geoJSON(hambanthotaD).addTo(map);
var jaffnas = L.geoJSON(jaffnaD).addTo(map);
var kalutharas = L.geoJSON(kalutharaD).addTo(map);
var kandys = L.geoJSON(kandyD).addTo(map);
var kegalles = L.geoJSON(kegalleD).addTo(map);
var kilinochchis = L.geoJSON(kilinochchiD).addTo(map);
var kurunegalas = L.geoJSON(kurunegalaD).addTo(map);
var mannar = L.geoJSON(mannarD).addTo(map);
var mathale = L.geoJSON(mathaleD).addTo(map);
var matharas = L.geoJSON(matharaD).addTo(map);
var mulathius = L.geoJSON(mulativD).addTo(map);
var nuwaraeliyas = L.geoJSON(nuwaraeliyaD).addTo(map);
var polonnaruwas = L.geoJSON(polonnaruwaD).addTo(map);
var puttalams = L.geoJSON(puttalamD).addTo(map);
var rathnapuras = L.geoJSON(rathnapuraD).addTo(map);
var trincos = L.geoJSON(trincoD).addTo(map);
var vavuniyas = L.geoJSON(vavuniyaD).addTo(map);




var polygondata = L.geoJSON(polygonJSON,


{
    onEachFeature: function(feature,layer){
        layer.bindPopup('<b>This is a </b>' + feature.properties.name)
    },
    style:{
        fillColor: 'red',
        fillOpacity:1,
        color: 'green'
    }
}).addTo(map);

/*===================================================
                      LAYER CONTROL               
===================================================*/

var baseLayers = {
    "Satellite":googleSat,
    "Google Map":googleStreets,
    "Water Color":Stamen_Watercolor,
    "OpenStreetMap": osm,
};

var overlays = {
    "Marker": singleMarker,
    "PointData":pointdata,
    "LineData":linedata,
    "PolygonData":polygondata
};

L.control.layers(baseLayers, overlays).addTo(map);


/*===================================================
                      SEARCH BUTTON               
===================================================*/

L.Control.geocoder().addTo(map);


/*===================================================
                      Choropleth Map               
===================================================*/


legend.addTo(map);


</script>
