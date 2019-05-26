<?php

namespace Chiroruxx\PaizaEnvPhp\Commands;

use Chiroruxx\PaizaEnvPhp\Helpers\Path;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CompilePaizaCodeCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'paiza:compile';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('Compile your code.')
            ->setHelp('Compile to paiza code from your code.')
            ->addArgument('target', InputArgument::REQUIRED, 'Your code directory name.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = $input->getArgument('target');
        $code = $this->generateCode($target);
        $this->writeFile($target, $code);
    }

    /**
     * Generate paiza code.
     *
     * @param string $target
     * @return string
     */
    private function generateCode(string $target): string
    {
        $code = '<?php' . PHP_EOL;

        $finder = new Finder();
        $finder->files()->in(Path::src($target));
        foreach ($finder as $file) {
            $code .= preg_replace('/^<\?php/', '', $file->getContents()) . PHP_EOL;
        }

        return $code;
    }

    /**
     * Write paiza code to file.
     *
     * @param string $target
     * @param string $code
     */
    private function writeFile(string $target, string $code): void
    {
        $fileSystem = new Filesystem();
        if (!$fileSystem->exists(Path::compiled())) {
            $fileSystem->mkdir(Path::compiled());
        }

        $fileSystem->dumpFile(Path::compiled("{$target}.php"), $code);
    }
}
