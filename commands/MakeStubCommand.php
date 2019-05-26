<?php

namespace Chiroruxx\PaizaEnvPhp\Commands;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class MakeStubCommand extends Command
{
    protected static $defaultName = 'paiza:make';

    /** @var string */
    private $basePath;
    /** @var Filesystem */
    private $fileSystem;

    protected function configure()
    {
        $this->setDescription('Make stub.')
            ->setHelp('Make stub.')
            ->addArgument('target', InputArgument::REQUIRED, 'Your code directory name.');

        $this->basePath = realpath(__DIR__ . '/..');
        $this->fileSystem = new Filesystem();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->resolvePath($input->getArgument('target'));
        $this->writeFile($path);
    }

    private function resolvePath(string $target)
    {
        $s = DIRECTORY_SEPARATOR;
        $path = "{$this->basePath}{$s}src{$s}{$target}";
        if ($this->fileSystem->exists($path)) {
            throw new RuntimeException("{$path} already exists.");
        }

        return $path;
    }

    private function writeFile(string $path)
    {
        $finder = new Finder();
        $s = DIRECTORY_SEPARATOR;
        $finder->in("{$this->basePath}{$s}templates");
        foreach ($finder as $file) {
            $main = $file->getContents();
            echo $file->getFilename();
            $this->fileSystem->dumpFile($path . DIRECTORY_SEPARATOR . $file->getFilename(), $main);
        }
    }
}
