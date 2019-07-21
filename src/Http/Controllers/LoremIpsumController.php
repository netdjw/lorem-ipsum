<?php

    namespace netdjw\LoremIpsum\Http\Controllers;

    use App\Http\Controllers\Controller;
    use netdjw\LoremIpsum\Models\LoremIpsum;

    class LoremIpsumController extends Controller {

        public function plainText(string $lang, string $limit) {
            return implode("\n\n", self::get($lang, $limit) );
        }


        public function html(string $lang, string $limit) {
            $paragraphs = self::get($lang, $limit);

            // move all paragraph item into a <p> tag
            for ($i = 0; $i < count($paragraphs); $i++) {
                $paragraphs[$i]  = '<p>'. $paragraphs[$i] .'</p>';
            }

            return implode("\n", $paragraphs);
        }


        private function get(string $lang, string $limit)
        {
            // check we have minimum words on selected language
            $words_in_language = LoremIpsum::where('lang', $lang)->get();

            if ( count($words_in_language) < 100) {
                return ['In this language we have not enough words in the database. Did you forgot run the seeder?'];
            }

            // array for results
            $paragraphs = [];

            // create paragraps
            for ($i = 0; $i < $limit; $i++) {
                // in paragraps we have sentences, the sentences limit is random
                $sentence_limit = random_int(3, 8);
                $sentences = [];

                // create fragments of sentences
                for ($j = 0; $j < $sentence_limit; $j++) {
                    // in senctences probable we have fragments, separated with commas
                    $fragments = [];
                    $commaChance = 0.33;

                    while (true) {
                        // set the words number in a fragment of a sentence
                        $word_limit = random_int(3, 7);

                        // we get random words from the dictionary
                        $words = self::randomFromDictionary($lang, $word_limit);

                        // set up the fragment
                        $fragments[] = implode(' ', $words);

                        // break the while loop if a random number is higher than the chance of a new fragment
                        if (self::random_float() >= $commaChance) {
                            break;
                        }

                        // we need to reduce the chance of commas after every run to avoid enless sentences
                        $commaChance /= 2;
                    }

                    // set up the sentences; every sentence start with uppercase character
                    $lower_case_sentence = implode(', ', $fragments);
                    // uppercase functionality for unicode characters too
                    $sentences[] = mb_convert_case(
                                        mb_substr($lower_case_sentence, 0, 1), MB_CASE_TITLE
                                    ) .
                                    mb_substr($lower_case_sentence, 1) . ".";
                }

                // set up the paragraps
                $paragraphs[] = implode(' ', $sentences);
            }

            // retrun as an array
            return $paragraphs;
        }


        private static function random_float() {
            return random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX;
        }


        private static function randomFromDictionary(string $lang, string $limit) {
            $items = LoremIpsum::where('lang', $lang)
                        ->inRandomOrder()
                        ->limit($limit)
                        ->get();
            $words = [];

            // start fragment with a short word
            if ( random_int(0, 1) === 1 ) {
                $short_items = LoremIpsum::where('lang', $lang)
                            ->whereRaw('LENGTH(word) <= ?', [3])
                            ->inRandomOrder()
                            ->limit(1)
                            ->get();
                array_push($words, $short_items[0]->word);
            }

            foreach ($items as $key => $item) {
                array_push($words, $item->word);
            }

            return $words;
        }
    }
