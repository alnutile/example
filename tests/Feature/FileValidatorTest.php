<?php

namespace Tests\Feature;

use App\FileValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class FileValidatorTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_is_valid_json(): void
    {
        $file = File::get(base_path('tests/fixtures/in_valid.json'));

        $results = (new FileValidator())->handle($file);

        $this->assertFalse($results);
    }

    public function test_valid_json(): void
    {
        $file = File::get(base_path('tests/fixtures/valid.json'));

        $results = (new FileValidator())->handle($file);

        $this->assertTrue($results);
    }

    public function test_starts_with_team_id(): void
    {
        $file = File::get(base_path('tests/fixtures/valid.json'));

        $results = (new FileValidator())->handle($file);

        $this->assertTrue($results);
    }

    public function test_app_id_missing(): void
    {
        $file = File::get(base_path('tests/fixtures/missing_app_id.json'));

        $results = (new FileValidator())->handle($file);

        $this->assertFalse($results);
    }
}
