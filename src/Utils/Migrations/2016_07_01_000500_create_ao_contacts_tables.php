<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAoContactsTables extends Migration
{

    public function up()
    {
        Schema::create('ao_contacts_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image');
            $table->string('activity');
            $table->string('site');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ao_contacts_phone_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('ao_contacts_email_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('ao_contacts_phones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('ao_contacts_contacts');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('ao_contacts_phone_types');
            $table->string('number', 50);
            $table->string('branch', 10);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ao_contacts_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('ao_contacts_contacts');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('ao_contacts_email_types');
            $table->string('email', 150);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('ao_contacts_emails');
        Schema::drop('ao_contacts_phones');
        Schema::drop('ao_contacts_email_types');
        Schema::drop('ao_contacts_phone_types');
        Schema::drop('ao_contacts_contacts');
    }

}