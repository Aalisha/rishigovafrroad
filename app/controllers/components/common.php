 <?php 
/***************************************************
* Common Component
*
*
*/
class CommonComponent extends Object{
  
/**
    *
    * @recursively check if a value is in array
    *
    * @param string $string (needle)
    *
    * @param array $array (haystack)
    *
    * @param bool $type (optional)
    *
    * @return bool
    *
    */
    function in_array_recursive($string, $array, $type=false)
    {
        /*** an recursive iterator object ***/
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
 
        /*** traverse the $iterator object ***/
        while($it->valid())
        {
            /*** check for a match ***/
            if( $type === false )
            {
                if( $it->current() == $string )
                {
                    return true;
                }
            }
            else
            {
                if( $it->current() === $string )
                {
                    return true;
                }
            }
            $it->next();
        }
        /*** if no match is found ***/
        return false;
    }
  
  
}

?> 