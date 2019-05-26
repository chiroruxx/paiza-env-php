<?php

namespace Chiroruxx\PaizaEnvPhp\Commands;

use Chiroruxx\PaizaEnvPhp\Helpers\Path;
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

    /** @var Filesystem */
    private $fileSystem;

    protected function configure()
    {
        $this->setDescription('Make stub.')
            ->setHelp('Make stub.')
            ->addArgument('target', InputArgument::REQUIRED, 'Your code directory name.');

        $this->fileSystem = new Filesystem();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->resolvePath($input->getArgument('target'));
        $this->writeFile($path);
    }

    private function resolvePath(string $target): string
    {
        $path = Path::src($target);
        if ($this->fileSystem->exists($path)) {
            throw new RuntimeException("{$path} already exists.");
        }

        return $path;
    }

    private function writeFile(string $path)
    {
        $finder = new Finder();
        $finder->in(Path::templates());
        foreach ($finder as $file) {
            $main = $file->getContents();
            $this->fileSystem->dumpFile(Path::build($path, $file->getFilename()), $main);
        }
    }
}
