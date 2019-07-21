# Multilingual Lorem Ipsum Generator for Laravel

## Install

Install the package:

    composer require netdjw/lorem-ipsum

Update the `config/app.php`:

    'providers' => [
        ...,
        App\Providers\RouteServiceProvider::class,
        
        // Our new package class
        netdjw\LoremIpsum\LoremIpsumServiceProvider::class,
    ],

### Select the language seeder

Use this method in your `database/seeds/DatabaseSeeder.php` file (for latin language):

    $this->call([
        'netdjw\LoremIpsum\Database\Seeds\LoremIpsumLaSeeder'
    ]);

Then run migration & seed:

    php artisan migrate --seed

If you want to use a different language change this:

    LoremIpsum[lang]Seeder.php

If you got an error on seeding then you need to create a `CreateLoremIpsumTable` migration. Use this command:

    php artisan make:migration CreateLoremIpsumTable

 Then find the migration file and fill with this content:

    <?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateLoremIpsumTable extends Migration
    {
        /**
        * Run the migrations.
        *
        * @return void
        */
        public function up()
        {
            Schema::create('lorem_ipsum', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('lang', 2)->default('la');
                $table->string('word', 255)->default('');
            });
        }

        /**
        * Reverse the migrations.
        *
        * @return void
        */
        public function down()
        {
            Schema::dropIfExists('lorem_ipsum');
        }
    }


#### Available languages

- english (en)
- hungarian (hu)
- latin (la)

## Use the package

    use netdjw\LoremIpsum\Http\Controllers\LoremIpsumController as LoremIpsum;

    // create new instance
    $lipsum = new LoremIpsum();

    // return 5 paragraphs latin plain text
    return $lipsum->plainText('la', 5);

    // return 3 praragraps english HTML text
    return $lipsum->html('en', 3);

# Thanks to

Based on this [StackOverflow question](https://stackoverflow.com/questions/20633310/how-to-get-random-text-from-lorem-ipsum-in-php)

Thanks for the great starter code for [mpen](https://stackoverflow.com/users/65387/mpen)

- English dictionary seeder from [here](https://github.com/first20hours/google-10000-english)
- Hungarian dictionary seeder from [here](http://szotar.com)
- Latin dictionary seeder from [here](http://latindictionary.wikidot.com/index)
