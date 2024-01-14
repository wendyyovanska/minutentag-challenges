<?php
class LetterCounter
{
    // EXCERCISE # 2: 
    public static function CountLettersAsString($inputString)
    {
        $letterCounts = [];

        // convert to lowercase the input string
        $inputString = strtolower($inputString);

        // this iterates each characters in the string
        for ($i = 0; $i < strlen($inputString); $i++) {
            $char = $inputString[$i];

            // Check if the character is a letter
            if (ctype_alpha($char)) {
                // Increment the count for the letter
                if (!isset($letterCounts[$char])) {
                    $letterCounts[$char] = 1;
                } else {
                    $letterCounts[$char]++;
                }
            }
        }

        // String result
        $resultString = '';
        foreach ($letterCounts as $letter => $count) {
            $resultString .= "$letter:" . str_repeat('*', $count) . ',';
        }

        // Remove the comma that is being used as a separator
        $resultString = rtrim($resultString, ',');

        return $resultString;
    }

    // EXCERCISE # 3: 
    public static function printCurrentDate()
    {
        $url = 'http://date.jsontest.com/';
        
        // read the file into string
        $jsonResponse = file_get_contents($url);

        // decodes a json string and converts it into a php value
        $data = json_decode($jsonResponse, true);

        // Extract the timestamp from the JSON response
        $timestamp = $data['milliseconds_since_epoch'] ?? null;

        if ($timestamp === null) {
            echo 'Not found';
            return;
        }

        // Format the date
        $formattedDate = date('l jS \of F, Y - h:i A', $timestamp / 1000);

        // Print the formatted date
        echo $formattedDate;
    }

    // EXCERCISE # 4: 
    public static function printResponseColumns()
    {
        $url = 'http://echo.jsontest.com/john/yes/tomas/no/belen/yes/peter/no/julie/no/gabriela/no/messi/no';
        $jsonResponse = file_get_contents($url);

        // decodes a json string and converts it into a php value
        $data = json_decode($jsonResponse, true);

        // Separate names based on 'yes' and 'no' responses
        $yesNames = [];
        $noNames = [];
        
        // iterates the array responses
        foreach ($data as $name => $response) {
            // if the response is yes, the name is added to the array yesNames
            if ($response === 'yes') {
                $yesNames[] = $name;
            } elseif ($response === 'no') { // if not, it is added to the array noNames
                $noNames[] = $name;
            }
        }

        // Print two columns of data
        echo "No Responses\t\tYes Responses\n";
        echo "-------------\t\t------------\n";

        // calculate the max number of items in the arrays
        $maxCount = max(count($yesNames), count($noNames));
        
        // iterates the items
        for ($i = 0; $i < $maxCount; $i++) {
            $yesName = $yesNames[$i] ?? '';
            $noName = $noNames[$i] ?? '';
            
            // print the table data
            echo str_pad($noName, 20, ' ', STR_PAD_RIGHT) . "\t\t" . str_pad($yesName, 20, ' ', STR_PAD_RIGHT) . "\n";
        }
    }
}

// Ex# 2: Input string of the test
$inputString = "Interview";
$result = LetterCounter::CountLettersAsString($inputString);
echo $result;

// Ex# 3: Result: printing current date
LetterCounter::printCurrentDate();

// Ex# 4: Result of names that said yes and no
LetterCounter::printResponseColumns();