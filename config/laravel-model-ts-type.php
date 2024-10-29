<?php

declare(strict_types=1);

return [
    // The root directory for all models
    'model_dir' => app_path('Models'),

    // The root directory for the type output
    'output_dir' => base_path('resources/definitions'),

    // The namespace of the generated Types
    'namespace' => false,

    // Whether the file name should be formatted to kebab case
    'noKebabCase' => false,

    // The amount of spaces used for indentation
    'indentation_spaces' => 4,
];
