<?php
// flight_redirect.php

// Your API credentials
$apiKey = 'GAkFKZKQrlQ705Tc1NzZuVhbG2M1h55g';
$apiSecret = 'AqpFbdDv8V6Aph1v';
$baseUrl = 'https://test.api.amadeus.com';

// Function to get access token
function getAccessToken($baseUrl, $apiKey, $apiSecret) {
    $url = "$baseUrl/v1/security/oauth2/token";
    
    $data = [
        'grant_type' => 'client_credentials',
        'client_id' => $apiKey,
        'client_secret' => $apiSecret,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    return $result['access_token'] ?? null;
}
// Function to map carrier code to airline name
function getAirlineName($carrierCode) {
    $airlines = [
        'JP' => 'Adria Airways',
        'EI' => 'Aerlingus',
        'SU' => 'Aeroflot',
        'AR' => 'Aerolineas Argen',
        'AM' => 'Aeromexico',
        '5L' => 'Aerosur',
        'VV' => 'Aerosvit',
        '8U' => 'Afriqiyah Airline',
        'AH' => 'Air Algerie',
        'KC' => 'Air Astana',
        'BT' => 'Air Baltic',
        'AB' => 'Air Berlin',
        '2J' => 'Air Burkina',
        'AC' => 'Air Canada',
        'CA' => 'Air China',
        'A7' => 'Air Comet',
        'UX' => 'Air Europa',
        'AF' => 'Air France',
        'AI' => 'Air India',
        'JM' => 'Air Jamaica',
        'KM' => 'Air Malta',
        'MK' => 'Air Mauritius',
        '9U' => 'Air Maldova',
        'SW' => 'Air Namibia',
        'NZ' => 'Air New Zealand',
        'HM' => 'Air Seychelles',
        'VT' => 'Air Tahiti',
        'TN' => 'Air Tahiti Nui',
        'TS' => 'Air Transat',
        'UM' => 'Air Zimbabwe',
        'AS' => 'Alaska Air',
        'LV' => 'Albanian Air',
        'AZ' => 'Alitalia',
        'NH' => 'All Nippon',
        'AA' => 'American Air',
        'OZ' => 'Asiana Airlines',
        'GR' => 'Aurigny',
        'OS' => 'Austrian Airline',
        'AV' => 'Avianca',
        'J2' => 'Azerbaijan',
        'UP' => 'Bahamasair',
        'PG' => 'Bangkok Airways',
        'BG' => 'Biman Bangla',
        'BD' => 'Bmi British',
        'BA' => 'British Airways',
        'SN' => 'Brussels Airline',
        'FB' => 'Bulgaria Air',
        'BW' => 'Caribbean Air',
        'CX' => 'Cathay Pacific',
        'CI' => 'China Airlines',
        'MU' => 'China Eastern',
        'CZ' => 'China Southern',
        'QI' => 'Cimber Sterli',
        'CF' => 'City Airline',
        'DE' => 'Condor',
        'CO' => 'Continental',
        'OU' => 'Croatia Air',
        'CU' => 'Cubana Airlines',
        'CY' => 'Cyprus Airways',
        'OK' => 'Czech Airlines',
        'D3' => 'Daallo',
        'DL' => 'Delta',
        'T3' => 'Eastern Airways',
        'MS' => 'Egyptair',
        'EK' => 'Emirates Air',
        'OV' => 'Estonian Air',
        'ET' => 'Ethiopian Air',
        'EY' => 'Etihad Airways',
        'BR' => 'EVA Airways',
        'AY' => 'Finnair',
        'BE' => 'Flybe',
        'GA' => 'Garuda',
        'GF' => 'Gulf Air',
        'HR' => 'Hahn Air',
        'HU' => 'Hainan Airlin',
        'YO' => 'Heli-Air Monaco',
        'EO' => 'Hewa Bora Air',
        'IB' => 'Iberia',
        'FI' => 'Iceland Air',
        'IC' => 'Indian Air',
        'IR' => 'Iran Air',
        '6H' => 'Israir',
        'JL' => 'Japan Airline',
        'JU' => 'Jat Airways',
        '9W' => 'Jet Airways',
        'KQ' => 'Kenya Airways',
        'KL' => 'KLM',
        'KE' => 'Korean Air',
        'KU' => 'Kuwait Airways',
        'LA' => 'Lan Airlines',
        'LO' => 'Lot-Polish',
        'LH' => 'Lufthansa',
        'CC' => 'Macair',
        'W5' => 'Mahan Air',
        'MA' => 'Malev',
        'MH' => 'Malaysia',
        'MP' => 'Martinair',
        'IG' => 'Meridiana',
        'MX' => 'Mexicana',
        'ME' => 'Middle East',
        'YM' => 'Montenegro',
        'CE' => 'Nationwide Air',
        'NW' => 'Northwest',
        'OA' => 'Olympic',
        'WY' => 'Oman Aviation',
        'PR' => 'Philippine',
        'QR' => 'Qatar Airways',
        'AT' => 'Royal Air Maroc',
        'BI' => 'Royal Brunei',
        'RJ' => 'Royal Jordanian',
        'FV' => 'Rossiya',
        'SK' => 'Sas',
        'S4' => 'Sata Intl',
        'SV' => 'Saudi Arabian',
        'S7' => 'Siberia Air',
        'SQ' => 'Singapore Airlines',
        'SA' => 'South African',
        'UL' => 'SriLankan',
        'SD' => 'Sudan',
        'LX' => 'Swiss',
        'RB' => 'Syrian Arab',
        'DT' => 'Taag-Angola',
        'VR' => 'Tacv Carbo Verdes',
        'JJ' => 'Tam Linhas Aerea',
        'TP' => 'Tap Portugal Airline',
        'TG' => 'Thai Intl',
        'UN' => 'Transaero',
        'TU' => 'Tunis Air',
        'TK' => 'Turkish Airlines',
        'QF' => 'Qantas Flights',
        'PS' => 'Ukraine Intl',
        'UA' => 'United',
        'US' => 'US Airways',
        'HY' => 'Uzbekistan',
        'VN' => 'Vietnam Air',
        'VS' => 'Virgin Atlantic',
        'VK' => 'Virgin Nigeria',
        'WM' => 'Windward Island',
        'IY' => 'Yemenia Yemen'  // Add more airline mappings here
    ];

    return $airlines[$carrierCode] ?? $carrierCode; // Return carrier code if name is not found
}

// Function to fetch flight offers
function fetchFlightOffers($accessToken, $origin, $destination, $departureDate, $returnDate = null, $adults = 1, $children = 0, $travelClass = 'ECONOMY') {
    global $baseUrl;

    $url = "$baseUrl/v2/shopping/flight-offers";
    
    $requestData = [
        "currencyCode" => "USD",
        "originDestinations" => [
            [
                "id" => "1",
                "originLocationCode" => $origin,
                "destinationLocationCode" => $destination,
                "departureDateTimeRange" => [
                    "date" => $departureDate,
                ]
            ]
        ],
        "travelers" => [],
        "sources" => ["GDS"],
    ];

    for ($i = 0; $i < $adults; $i++) {
        $requestData['travelers'][] = [
            "id" => strval($i + 1),
            "travelerType" => "ADULT"
        ];
    }
    for ($i = 0; $i < $children; $i++) {
        $requestData['travelers'][] = [
            "id" => strval($adults + $i + 1),
            "travelerType" => "CHILD"
        ];
    }

    if ($returnDate) {
        $requestData['originDestinations'][] = [
            "id" => "2",
            "originLocationCode" => $destination,
            "destinationLocationCode" => $origin,
            "departureDateTimeRange" => [
                "date" => $returnDate,
            ]
        ];
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $accessToken",
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Main logic: Process form inputs dynamically
$flightOffers = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $origin = $_POST['airport-from'] ?? 'NYC';
    $destination = $_POST['airport-to'] ?? 'MAD';
    $departureDate = $_POST['departing'] ?? date('Y-m-d');
    $returnDate = $_POST['returning'] ?? null;
    $adults = $_POST['adults'] ?? 1;
    $children = $_POST['children'] ?? 0;
    $infants = $_POST['infants'] ?? 0;
    $travelClass = $_POST['travel-class'] ?? 'ECONOMY';

    $accessToken = getAccessToken($baseUrl, $apiKey, $apiSecret);

    if ($accessToken) {
        $flightOffers = fetchFlightOffers($accessToken, $origin, $destination, $departureDate, $returnDate, $adults, $children, $travelClass);
    }

    // Redirect if no flight offers are found
    if (empty($flightOffers['data'])) {
        header('Location: getcall.html');
        exit(); // Make sure to exit after header to stop script execution
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Travels - Flight Offers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Favicon -->
    <link href="img/LOGOF.webp" rel="icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url('https://c0.wallpaperflare.com/preview/472/406/560/aero-aircraft-airplane-airplanes.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        header {
            background-color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 90px;
            width: 220px;
        }
        .call-to-action {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #ffffff;
            background-color: #ff5733;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .call-to-action i {
            margin-right: 8px;
            font-size: 1.2rem;
        }
        .call-to-action:hover {
            background-color: #e04a2b;
        }
        footer {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

/* Flight Cards Container */
.travel-details-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Arial', sans-serif;
    color: #333;
}

/* Individual Flight Card */
.flight-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    background: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.flight-card:hover {
    transform: translateY(-3px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

/* Time Information */
.time-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-size: 16px;
    color: #444;
    font-weight: 500;
}

/* Flight Arrow and Details */
.flight-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex: 2;
    font-size: 14px;
    position: relative;
    color: #888;
}

/* Extra Info on Flight Arrow */
.flight-extra-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.flight-extra-info i {
    font-size: 16px;
    color: #555;
}

.flight-extra-info .travel-time {
    font-weight: bold;
    color: #555;
}

.flight-extra-info .price {
    font-weight: bold;
    color: #1d3557;
}

/* Airline Information */
.airline-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #555;
    margin-top: 10px;
}

.airline-info .airline {
    font-weight: bold;
}

.airline-info .flight-number {
    font-style: italic;
    color: #888;
}

/* Book Now Button */
.book-now {
    text-align: center;
    margin-top: 15px;
}

.book-now .book-button {
    display: inline-block;
    padding: 8px 15px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background: #1d3557;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease;
}

.book-now .book-button:hover {
    background: #457b9d;
}

/* Mobile Responsiveness */
@media (max-width: 600px) {
    .time-info {
        flex-direction: column;
        text-align: center;
        gap: 5px;
    }

    .flight-arrow {
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .airline-info {
        flex-direction: column;
        text-align: center;
        gap: 5px;
    }
}


    </style>
</head>
<body>

<header>
    <a class="navbar-brand">
        <img src="img/LOGO.webp"alt="Dream Logo">
    </a>
    <a href="tel:+1 18007166253" class="call-to-action">Get the best fare. Call Now!</a>
</header>

<div class="travel-details-container">
    <?php foreach ($flightOffers['data'] as $offer): 
        $outboundFlight = [];
        $returnFlight = [];
        
        foreach ($offer['itineraries'] as $itineraryIndex => $itinerary) {
            // Dynamic Data Preparation for Each Itinerary
            $departureDateTime = new DateTime($itinerary['segments'][0]['departure']['at']);
            $arrivalDateTime = new DateTime($itinerary['segments'][count($itinerary['segments']) - 1]['arrival']['at']);
            $carrierCode = $itinerary['segments'][0]['carrierCode'];
            $airlineName = getAirlineName($carrierCode);
            
            // Flight data
            $departureTime = htmlspecialchars($departureDateTime->format('Y-m-d h:i A'));
            $arrivalTime = htmlspecialchars($arrivalDateTime->format('Y-m-d h:i A'));
            $departureIATA = htmlspecialchars($itinerary['segments'][0]['departure']['iataCode']);
            $arrivalIATA = htmlspecialchars($itinerary['segments'][count($itinerary['segments']) - 1]['arrival']['iataCode']);
            $flightNumber = htmlspecialchars($itinerary['segments'][0]['number']);

            // Duration calculation
            $totalTime = $departureDateTime->diff($arrivalDateTime);
            $formattedTime = $totalTime->format('%h hr %i min');

            // Pricing
            $originalPrice = $offer['price']['grandTotal'];
            $discountedPrice = number_format($originalPrice * 0.85, 2);

            // Separate Data for Outbound and Return Flights
            if ($itineraryIndex === 0) { // Outbound Flight
                $outboundFlight = [
                    'departure_time' => $departureTime,
                    'arrival_time' => $arrivalTime,
                    'departure_iata' => $departureIATA,
                    'arrival_iata' => $arrivalIATA,
                    'airline' => $airlineName,
                    'travel_time' => $formattedTime
                ];
            } elseif ($itineraryIndex === 1) { // Return Flight
                $returnFlight = [
                    'departure_time' => $departureTime,
                    'arrival_time' => $arrivalTime,
                    'departure_iata' => $departureIATA,
                    'arrival_iata' => $arrivalIATA,
                    'airline' => $airlineName,
                    'travel_time' => $formattedTime
                ];
            }
    ?>
    <div class="flight-card">
        <!-- Flight Type (Outbound or Return) -->
        <div class="flight-type">
            <h4><?= $itineraryIndex === 0 ? "Outbound Flight" : "Return Flight" ?></h4>
        </div>

        <!-- Flight Times and Travel Info -->
        <div class="time-info">
            <span class="departure"><?= $departureTime ?> <?= $departureIATA ?></span>
            <span class="flight-arrow">
                <div class="flight-extra-info">
                    -----<span class="travel-time"><?= $formattedTime ?></span>
                    <i class="fas fa-plane"></i>-----
                    <span class="price">$<?= $discountedPrice ?></span>
                </div>
            </span>
            <span class="arrival"><?= $arrivalTime ?> <?= $arrivalIATA ?></span>
        </div>

        <!-- Airline Name and Flight Number -->
        <div class="airline-info">
            <span class="airline">Airline: <?= htmlspecialchars($airlineName) ?></span>
            <span class="flight-number">Flight: <?= htmlspecialchars($flightNumber) ?></span>
        </div>
        
    </div>
    <?php } // End of itineraries loop ?>
    
    <!-- Book Now Button -->
    <div class="book-now">
    <a href="payment.php?price=<?= htmlspecialchars($discountedPrice) ?>
        &flight_id=<?= htmlspecialchars($offer['id']) ?>
        &departure_time=<?= urlencode($outboundFlight['departure_time']) ?>
        &arrival_time=<?= urlencode($outboundFlight['arrival_time']) ?>
        &from=<?= htmlspecialchars($outboundFlight['departure_iata']) ?>
        &to=<?= htmlspecialchars($outboundFlight['arrival_iata']) ?>
        &travel_class=<?= urlencode($travelClass) ?>
        &adults=<?= htmlspecialchars($adults) ?>
        &children=<?= htmlspecialchars($children) ?>
        &infants=<?= htmlspecialchars($infants) ?>
        &airline=<?= urlencode($outboundFlight['airline']) ?>
        <?php if (!empty($returnFlight)): ?>
        &return_departure_time=<?= urlencode($returnFlight['departure_time']) ?>
        &return_arrival_time=<?= urlencode($returnFlight['arrival_time']) ?>
        &return_departure_timezone=<?= urlencode($returnFlight['departure_iata']) ?>
        <?php endif; ?>" 
        class="book-button">Book Now</a>
</div><br>

    <?php endforeach; // End of offers loop ?>
</div>







<footer>
    <p>&copy; 2025 Dream Travels. All rights reserved.</p>
</footer>

</body>
</html>
