<?php

namespace App\Console\Commands;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeValidation extends Command
{
    protected $signature = 'make:validation {name}';
    protected $description = 'Create a new validation class';

    public function handle(): void
    {
        $name = $this->argument('name');
        $path = app_path("Validations/{$name}.php");

        if (File::exists($path)) {
            $this->error('Validation class already exists!');
            return;
        }

        $stub = $this->getStub();

        $content = str_replace(
            ['{{className}}'],
            [$name],
            $stub
        );

        File::ensureDirectoryExists(app_path('Validations'));
        File::put($path, $content);

        $relativePath = str_replace(base_path().'/', '', $path);
        $this->info('Validation class ['.$relativePath.'] created successfully.');
    }

    protected function getStub()
    {
        return <<<'STUB'
        <?php

        namespace App\Validations;

        class {{className}}
        {
            public static function rules(): array
            {
                return [
                    // Add your validation rules here
                ];
            }
        }
        STUB;
    }
}


