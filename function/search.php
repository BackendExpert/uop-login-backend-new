<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Only allow GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["error" => "Only GET requests supported"]);
    exit;
}

// Validate action
$action = $_GET['action'] ?? '';
if ($action !== 'search') {
    echo json_encode(["error" => "Invalid or missing action parameter"]);
    exit;
}

// Validate query
$query = $_GET['query'] ?? '';
if (!$query) {
    echo json_encode(["error" => "Missing query parameter"]);
    exit;
}

$searchQuery = urlencode("site:pdn.ac.lk $query");
$url = "https://www.google.com/search?q=$searchQuery";

// Setup cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$html = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

// Save raw HTML for debugging
file_put_contents("debug.html", $html);

if (!$html) {
    echo json_encode(["error" => "Failed to fetch search results: $curlError"]);
    exit;
}

// Detect Google block/CAPTCHA
if (
    stripos($html, "Our systems have detected unusual traffic") !== false ||
    stripos($html, "detected unusual traffic") !== false ||
    stripos($html, "To continue, please type the characters") !== false ||
    stripos($html, "captcha") !== false
) {
    echo json_encode([
        "error" => "Google blocked the request or CAPTCHA required. Try again later or use a search API."
    ]);
    exit;
}

// Parse HTML
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$loaded = $dom->loadHTML($html);
libxml_clear_errors();

if (!$loaded) {
    echo json_encode(["error" => "Failed to parse HTML"]);
    exit;
}

$xpath = new DOMXPath($dom);

// Try modern structure
$results = [];
$nodes = $xpath->query('//div[contains(@class, "tF2Cxc")]');

foreach ($nodes as $node) {
    $titleNode = $xpath->query('.//h3', $node)->item(0);
    $linkNode = $xpath->query('.//a', $node)->item(0);
    $snippetNode = $xpath->query('.//div[contains(@class, "VwiC3b") or contains(@class, "lyLwlc")]', $node)->item(0);

    if ($titleNode && $linkNode) {
        $results[] = [
            "title" => trim($titleNode->nodeValue),
            "link" => $linkNode->getAttribute('href'),
            "snippet" => $snippetNode ? trim($snippetNode->nodeValue) : ''
        ];
    }
}

// Fallback to older Google layout
if (count($results) === 0) {
    $nodes = $xpath->query('//div[@class="g"]');
    foreach ($nodes as $node) {
        $linkNode = $xpath->query('.//a', $node)->item(0);
        $titleNode = $xpath->query('.//h3', $node)->item(0);
        $snippetNode = $xpath->query('.//span[@class="aCOpRe"]', $node)->item(0);

        if ($titleNode && $linkNode) {
            $results[] = [
                "title" => trim($titleNode->nodeValue),
                "link" => $linkNode->getAttribute('href'),
                "snippet" => $snippetNode ? trim($snippetNode->nodeValue) : ''
            ];
        }
    }
}

// Still no results? Show debug counts
if (count($results) === 0) {
    echo json_encode([
        "error" => "No search results found or page structure changed",
        "count_tF2Cxc" => $xpath->query('//div[contains(@class, "tF2Cxc")]')->length,
        "count_g" => $xpath->query('//div[@class="g"]')->length
    ]);
    exit;
}

// Return search results
echo json_encode($results);
exit;
