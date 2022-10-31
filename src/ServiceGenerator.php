<?php

namespace Dorsone\LaravelService;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ServiceGenerator extends GeneratorCommand
{

    const SUCCESS = 0;
    const FAILURE = 1;

    private bool $isConstructFound = false;

    private string $controllerNamespace = "App/Http/Controllers";

    protected function getStub(): string
    {
        return __DIR__ . '/Stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }

    private function getControllerName(): ?string
    {
        return str_replace("\\", "/", $this->option('controller'));
    }

    private function getServiceNamespace(): string
    {
        return $this->qualifyClass($this->getNameInput());
    }

    private function getServiceName(): string
    {
        return Str::camel(class_basename($this->getServiceNamespace()));
    }

    private function getControllerPath(): string
    {
        return "$this->controllerNamespace/" . $this->getControllerName() . ".php";
    }

    private function getControllerFile(): bool|array
    {
        return file($this->getControllerPath());
    }

    private function controllerFileExists(): bool
    {
        return file_exists($this->getControllerPath());
    }

    public function generateService(): int
    {
        $controllerIsNotCreated = $this->generateController();

        if (!$controllerIsNotCreated) {
            $controller = $this->getControllerFile();
            $controller = $this->ifConstructExist($controller);
            if (is_int($controller)) {
                return $controller;
            }
            $controller = $this->ifConstructEmpty($controller);
            file_put_contents($this->getControllerPath(), $controller);
            $this->components->info("Service linked in " . $this->getControllerName());
        } else {
            return self::FAILURE;
        }


        return self::SUCCESS;
    }

    public function ifConstructEmpty(array $file): array
    {
        if (!$this->isConstructFound) {
            foreach ($file as &$code) {
                if (preg_match("/^(\s+|)(public|protected|private)\s+function/", $code)) {
                    $code = $this->createConstruct($code);
                    break;
                }
            }
        }

        if (!$this->isConstructFound) {
            foreach ($file as &$code) {
                if (str_contains($code, "}")) {
                    $code = $this->createConstruct($code);
                    break;
                }
            }
            $this->isConstructFound = true;
        }
        return $file;
    }

    private function createConstruct($code): string
    {
        return "\tpublic \\" . $this->getServiceNamespace() . " \$" . $this->getServiceName() . ";"
            . PHP_EOL . PHP_EOL . "\tpublic function __construct(\\" . $this->getServiceNamespace(
            ) . " \$" . $this->getServiceName() . ")"
            . PHP_EOL . "\t{" . PHP_EOL . "\t\t\$this->" . $this->getServiceName() . " = \$" . $this->getServiceName(
            ) . ";"
            . PHP_EOL . "\t}" . PHP_EOL . PHP_EOL . $code;
    }

    private function ifConstructExist(array $file): int|array
    {
        foreach ($file as $line => &$code) {
            if (preg_match("/^(\s+|)public\s+function\s+__construct\(/", $code)) {
                $this->isConstructFound = true;
                if (preg_match("/\(\)/", $code)) {
                    $code = "\tpublic function __construct(\\" . $this->getServiceNamespace(
                        ) . " \$" . $this->getServiceName() . ")";
                } else {
                    if (str_contains(implode("", $file), $this->getServiceNamespace())) {
                        $this->components->warn("Service already linked in " . $this->getControllerName());
                        return self::SUCCESS;
                    }
                    $code = preg_replace(
                        "/\)/",
                        ", \\" . $this->getServiceNamespace() . " \$" . $this->getServiceName() . ")",
                        $code
                    );
                }
                $file[$line + 1] = "\t{" . PHP_EOL . "\t\t\$this->" . $this->getServiceName(
                    ) . " = \$" . $this->getServiceName() . ";" . PHP_EOL;
                $code = "\tpublic \\" . $this->getServiceNamespace() . " \$" . $this->getServiceName(
                    ) . ";" . PHP_EOL . PHP_EOL . $code;
                break;
            }
        }
        return $file;
    }

    private function generateController(): bool
    {
        $controllerFileDoesntExist = !$this->controllerFileExists();

        if ($controllerFileDoesntExist) {
            $isResponseStatusTrue = $this->confirm("Do you want to create " . $this->getControllerPath() . "?");
            if ($isResponseStatusTrue) {
                Artisan::call("make:controller " . $this->getControllerName());
                $this->components->info("Created " . $this->getControllerName());
            }
        }

        return self::SUCCESS;
    }


}
