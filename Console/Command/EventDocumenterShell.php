<?php
/**
 * AppShell file
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

// TODO
// Folder choosing
// Output location

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class EventDocumenterShell extends AppShell {

	public function document(){
		// For now, I am limiting these to the model and controller until further testing has been done
		$dirs = ['Model', 'Controller'];
		foreach($dirs as $dir){
			$dir = new Folder($dir);
			$files = $dir->findRecursive('.*');
			$all_events = '';
			// Lets look through the files to find all the events in them
			foreach($files as $file){
				$events = '';
				$file = new File($file);
				$contents = $file->read();
				preg_match_all('/(\/\/\s?(?P<Comment>.*)?$\n.*)?new CakeEvent\(\'(?P<Event>.*?)\'/m', $contents, $matches);
				$i = 0;
				foreach($matches['Event'] as $event){
					$all_events .= $events .= "\t * ".$event.' - '.$matches['Comment'][$i]."\n";
					$i++;
				}
				// If events were found
				// Add them to the top
				if($events != ''){
					$event_comment = "/**\n\t * Available Events\n";
					$event_comment .= $events;
					$event_comment .= "\t */";
					// This will find the class declaration line and the available events line if it exist
					$contents = preg_replace('/(class.*extends.*?{)(.*\/\*\*.*Available Events.*?\*\/)?/ms', '\1'."\n\n\t".$event_comment, $contents);
					if($this->params['dryrun'] == 'true'){
						$this->out($file->name().' would be modified');
					}elseif($file->write($contents)){
						$this->out($file->name().' has been modified');
					}
				}
			}
		}
		$this->out('done');
		exit;
	}


	public function getOptionParser() {
		$parser = parent::getOptionParser();
		return $parser->description(array(
			'Event Documenter Shell',
			'',
			'Puts a comment with all your events at the top of your models and controllers'
		))->command('document', array(
			'help' => 'Document your events'
		))->addOption('dryrun', array(
			'help' => 'By default no files will be modified',
			'short' => 'd',
			'default' => 'true'
		));
	}
}
