<?php

namespace Chiroruxx\PaizaEnvPhp\Commands;

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

    /** @var string */
    private $baseDir;

    /** @var string */
    private $srcDir;

    /** @var string */
    private $outputDir;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('Compile your code.')
            ->setHelp('Compile to paiza code from your code.')
            ->addArgument('target', InputArgument::REQUIRED, 'Your code directory name.');

        $this->baseDir = realpath(__DIR__ . '/..');
        $s = DIRECTORY_SEPARATOR;
        $this->srcDir = "{$this->baseDir}{$s}src{$s}";
        $this->outputDir = "{$this->baseDir}{$s}compiled{$s}";
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
        $finder->files()->in("{$this->srcDir}{$target}");
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
        if (!$fileSystem->exists($this->outputDir)) {
            $fileSystem->mkdir($this->outputDir);
        }

        $fileSystem->dumpFile("{$this->outputDir}{$target}.php", $code);
    }
}
