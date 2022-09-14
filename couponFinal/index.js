// --* Za kreiranje coupons tabele *-- //

// $table->id();
// $table->string('code')->unique();
// $table->unsignedBigInteger('type_id');
// $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
// $table->unsignedBigInteger('subtype_id');
// $table->foreign('subtype_id')->references('id')->on('subtypes')->onDelete('cascade')->onUpdate('cascade');
// $table->enum('status', ['active', 'used'])->default('active');
// $table->integer('value');
// $table->integer('limit');
// $table->unsignedBigInteger('status_id');
// $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade')->onUpdate('cascade');
// $table->date('valid_until');
// $table->timestamps();

// Znaci iz tabele COUPONS cemo izvuci kolonu CODE i prebaciti u tabelu EMAILS da generise kod za svaki mejl koji kacimo sa kuponom
