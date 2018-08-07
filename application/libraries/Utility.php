<?php
    class Utility{
    function _uniord($file)//reads file content as a stirng 
    {
        //converting the decimal ascii value to hex value gives the unicode of character
        $file_uni = '';  //this variable is used to store unicode of the text in file
        $file_u = '';   //this is a temporaty variable which stores the ascii value of the given text
        for($i=0; $i<strlen($file);$i++)  //loop runs for every character in the file and runs untill the end of file
        {


            if (ord($file{$i}) >=0 && ord($file{$i}) <= 127) 
            {
                /**
                * if the character occupies one byte then the byte order will be
                * 0vvvvvvv that means the ascii value of the character varies from 0 to 127         
                */                 
                $file_u = ord($file{$i});  //ascii value of the character
                $file_uni .= '/u'.dechex($file_u);  //converting the decimal ascii value to hex value gives the unicode of character
            }
            if (ord($file{$i}) >= 192 && ord($file{$i}) <= 223)
            {
                /**
                * if the character occupies two bytes then the byte order will be
                * 110vvvvv 10vvvvvv hence the leading character ascii value varies 
                * from 192 to 223         
                */                   
                $file_u = (ord($file{$i})-192)*64 + (ord($file{$i+1})-128);  
                $file_uni .= '/u'.dechex($file_u);
                $i += 1;    

            }
            if (ord($file{$i}) >= 224 && ord($file{$i}) <= 239)
            {
                /**
                * if the character occupies two bytes then the byte order will be
                * 1110vvvv 10vvvvvv 10vvvvvv hence the leading character ascii value varies 
                * from 192 to 223         
                */
                $file_u = (ord($file{$i})-224)*4096 + (ord($file{$i+1})-128)*64 + (ord($file{$i+2})-128);
                $file_uni .= '/u'.dechex($file_u);
                $i += 2;

            }
            if (ord($file{$i}) >= 240 && ord($file{$i}) <= 247)
            {   
                /** 
                * if the character occupies two bytes then the byte order will be
                * 11110vvv 10vvvvvv 10vvvvvv 10vvvvvv hence the leading character ascii value varies 
                * from 192 to 223         
                */
                $file_u = (ord($file{$i})-240)*262144 + (ord($file{$i+1})-128)*4096 + (ord($file{$i+2})-128)*64 + (ord($file{$i+3})-128);
                $file_uni .= '/u'.dechex($file_u);
                $i += 3;

            }
            if (ord($file{$i}) >= 248 && ord($file{$i}) <= 251)
            { 
                /**
                * if the character occupies 5 bytes then the byte order will be
                * 111110vv 10vvvvvv 10vvvvvv 10vvvvvv 10vvvvvv hence the leading character ascii value varies 
                * from 248 to 251         
                */
                $file_u = (ord($file{$i})-248)*16777216 + (ord($file{$i+1})-128)*262144 + (ord($file{$i+2})-128)*4096 + (ord($file{$i+3})-128)*64 + (ord($file{$i+4})-128);
                $file_uni .= '/u'.dechex($file_u);
                $i += 4;

            }
            if (ord($file{$i}) >= 252 && ord($file{$i}) <= 253)
            {
                /**
                * if the character occupies 6 bytes then the byte order will be
                * 1111110v 10vvvvvv 10vvvvvv 10vvvvvv 10vvvvvv 10vvvvvv 
                * hence the leading character ascii value varies 
                * from 252 to 253         
                */    
                $file_u = (ord($file{$i})-252)*1073741824 + (ord($file{$i+1})-128)*16777216 + (ord($file{$i+2})-128)*262144 + (ord($file{$i+3})-128)*4096 + (ord($file{$i+4})-128)*64 + (ord($file{$i+5})-128);
                $file_uni .= '/u'.dechex($file_u);
                $i += 5;

            }
            if (ord($file{$i}) >= 254 && ord($file{$i}) <= 255)  //unicode doesnt exist for 254 and 255 as these define the language
                return FALSE;

        }

        return $file_uni; // Returning converted unicode stream

    }
    function _unichr($o) //Reads Unicode string
    {
        $text_ord = ''; //To store Converted characters
        $arr = array(); //To store decimal values of unicode
        for($i=0; $i<strlen($o);$i++) //loop untill the last character
        {
            $a = ''; //Temp variable to store decimal value
            if($o[$i] == 'u' && $i<strlen($o)) // Unicode Starts with /u0000 
            {
                while($o[$i] != '/' && $i<strlen($o)-1) //Reading untill next unicode character and '/' cannot be last character as 'u' always follows '/'
                {
                    $a .= $o[$i]; // Concatanating each digit
                    $i++; //Moving to next digit in string $o
                }

            }
            array_push($arr , $a); // Entering hex value into array

        }
        foreach($arr as $ar){ //for each array element
            $ord = hexdec($ar); // converting hex value to decimal
            if (function_exists('mb_convert_encoding')) { // if the decimal value is from utf8 characterset
                $text_ord .=  mb_convert_encoding('&#'.intval($ord).';', 'UTF-8', 'HTML-ENTITIES'); // converting to unicode character
            } 
            else {
                $text_ord .= chr(intval($ord)); //converting into ASCII character
            }
        }

        return $text_ord;  // Returning concatenated and unicode converted string

    }
    }
?>
