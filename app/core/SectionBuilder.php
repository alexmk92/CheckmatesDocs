<?php

class SectionBuilder
{

    /*
     * Renders a block with the method name header, the description
     * for that method and the type of method it is (GET, PUT, POST, DELETE)
     */
    public function renderHeader($methodName, $summary, $description, $type, $uri, $usage)
    {
        $color   = self::getColor($type);
        $output  = "<h3 id='".$methodName."'>".$summary."</h3>";
        $output .= "<p class='badge ".$color."'>".$type."</p>";
        $output .= "<p>You can use this method by sending a request to <mark>".URL."/".$uri."</mark></p>";
        $output .= "<p>".$description."</p>";
        $output .= "<h4>Usage:</h4>";
        $output .= "<p>".$usage."</p>";

        echo $output;
    }

    /*
     * Builds the uri component chunk, this will be based off an associative
     * array sent with values $k = (string)parameterName $v = (string)info
     */
    public function renderURIComponents($components)
    {
        $output  = "<br>";
        $output .= "<h4>URI Components:</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Component</th>";
        $output .= "<th>Summary</th>";
        $output .= "</tr>";
        $output .= "</thead>";

        // Build the response input
        foreach($components as $k => $v)
        {
            $output .= "<tr>";
            $output .= "<td>".$k."</td>";
            $output .= "<td>".$v."</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    /*
     * Builds the header information chunk, this will be based off an associative
     * array sent with values $k = (string)parameterName $v = (string)info
     */
    public function renderHeaderInformation($information)
    {
        $output  = "<br>";
        $output .= "<h4>Header Information:</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Key</th>";
        $output .= "<th>Summary</th>";
        $output .= "</tr>";
        $output .= "</thead>";

        // Build the response input
        foreach($information as $k => $v)
        {
            $output .= "<tr>";
            $output .= "<td>".$k."</td>";
            $output .= "<td>".$v."</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    /*
     * Builds the input parameter chunk, this will be based off an associative
     * array sent with values $k = (string)parameterName $v = (string)info
     */
    public function renderInputParameters($parameters)
    {
        $output  = "<br>";
        $output .= "<h4>Input Parameters:</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Parameter</th>";
        $output .= "<th>Summary</th>";
        $output .= "</tr>";
        $output .= "</thead>";

        // Build the response input
        foreach($parameters as $k => $v)
        {
            $output .= "<tr>";
            $output .= "<td>".$k."</td>";
            $output .= "<td>".$v."</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    /*
     * Builds the input parameter chunk, this will be based off an associative
     * array sent with values $k = (string)parameterName $v = (string)info
     */
    public function renderOutputInfo($parameters)
    {
        $output  = "<br>";
        $output .= "<h4>Output Description:</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Key</th>";
        $output .= "<th>Summary</th>";
        $output .= "</tr>";
        $output .= "</thead>";

        // Build the response input
        foreach($parameters as $k => $v)
        {
            $output .= "<tr>";
            $output .= "<td>".$k."</td>";
            $output .= "<td>".$v."</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    /*
     * Builds the response code chunk, this will be based off an associative array
     * sent with the values $k = (int)code, $v = (string)summary
     */
    public function renderResponseCodes($codes)
    {
        $output  = "<br>";
        $output .= "<h4>Response Codes:</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead>";
        $output .= "<tr>";
        $output .= "<th>Code</th>";
        $output .= "<th>Summary</th>";
        $output .= "</tr>";
        $output .= "</thead>";

        // Build the response input
        foreach($codes as $k => $v)
        {
            $output .= "<tr>";
            $output .= "<td>".$k."</td>";
            $output .= "<td>".$v."</td>";
            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    public function renderTestResponse($headers = Array(), $parameters = Array(), $url, $type)
    {
        echo "<h4>Example Response:</h4>\n";
        echo "<p>The example below is based upon a master system session_token and device_id, using a pre-defined query.  The results here will be updated as the API is expanded, but you cannot provide your own parameters here to change the output.</p>";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if($type != "GET")
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
        if($type != "GET" && $type != "POST")
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);

        $res = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($res);
        echo "<pre>".json_encode($json, JSON_PRETTY_PRINT)."</pre>";

    }

    /*
     * Returns the color for the badge for a specific REST request
     */
    private function getColor($methodType)
    {
        $methodType = strtoupper($methodType);
        switch ($methodType)
        {
            case "GET":
                return "green";
                break;
            case "PUT":
                return "blue";
                break;
            case "POST";
                return "yellow";
                break;
            case "DELETE":
                return "red";
                break;
            default:
                return "";
                break;
        }
    }
}