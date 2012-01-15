#Wikipedia Helper#

##Description##


Helper class for Wikipedia API

### Helper ###

lib/wikipedia\_helper.php - wikipedia API

### Tests ###

test/wikipedia\_helper\_tests.php - unit tests for wikipedia API


##Examples##

###(1) Opensearch###

####Code####

    <?php
        include_once('wikipedia_helper.php');
        $x = new Wikipedia_helper();
        $search_terms = array('foo', 'bar');
        $search_results_limit = 2;
        $results = $x->getOpensearchResults($search_terms, $search_results_limit);
        print_r($results);

####Output####


    Array
    (
        [foo] => Array
            (
                [Association football] => Array
                    (
                        [description] => Association football, more commonly known as football or soccer, is a sport played between two teams of eleven players with a spherical ball. 
                        [url] => http://en.wikipedia.org/wiki/Association_football
                    )

                [Football League Cup] => Array
                    (
                        [description] => The Football League Cup, commonly known as the League Cup or, from current sponsorship, the Carling Cup, is an English association football competition. 
                        [url] => http://en.wikipedia.org/wiki/Football_League_Cup
                    )
            )

        [bar] => Array
            (
                [Barcelona] => Array
                    (
                        [description] => Barcelona (, ) is the second largest city in Spain after Madrid, and the capital  of Catalonia, with a population of 1,621,537 within its administrative limits on a land area of . 
                        [url] => http://en.wikipedia.org/wiki/Barcelona
                    )

                [Barack Obama] => Array
                    (
                        [description] => Barack Hussein Obama II (; born August 4, 1961) is the 44th and current President of the United States. 
                        [url] => http://en.wikipedia.org/wiki/Barack_Obama
                    )
            )
    )

