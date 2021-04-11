<?php

namespace App\Command;

use App\Collector\GeneratorCollection;
use App\Dictionary\FileExtension;
use App\Factory\FileFactory;
use App\Services\GenerateRandomCharactersInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateRandomCharacters extends Command
{
    private const PATH_TMP = 'var/tmp/';

    protected static $defaultName = 'generate:random-characters';
    protected static $defaultDescription = 'application fetch random numbers from API';

    private GeneratorCollection $generatorCollector;
    private Filesystem $fileSystem;


    public function __construct(GeneratorCollection $generateRandomCharacters, FileFactory $factory, Filesystem $filesystem)
    {
        parent::__construct();

        $this->generatorCollector = $generateRandomCharacters;
        $this->fileSystem = $filesystem;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('count-number', InputArgument::REQUIRED, 'please specified how much number should be generated');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countSets = $input->getArgument('count-number');


        if ($this->fileSystem->exists(GenerateRandomCharacters::PATH_TMP)
            && $this->fileSystem->exists([GenerateRandomCharacters::PATH_TMP.'SetA.txt',GenerateRandomCharacters::PATH_TMP.'SetB.txt'])) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('This action override exist temp files, Are you sure you want continue? ', false);


            if (!$helper->ask($input, $output, $question)) {
                return Command::SUCCESS;
            }
        }

        foreach ($this->generatorCollector->getCollection() as $generator) {
            /** @var  $generator GenerateRandomCharactersInterface */
            $generatedData = $generator->generate($countSets);

            //create tmp data
            $this->fileSystem->dumpFile('var/tmp/'.$generator->getSetName(). '.txt', serialize($generatedData));
        }
        $io->success('Generated success sets A and B');

        return Command::SUCCESS;
    }
}
