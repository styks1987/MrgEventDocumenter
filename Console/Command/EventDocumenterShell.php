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
// Dryrun
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

	public function document($dryrun = true){
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
				if($events != ''){
					$event_comment = "/**\n\t * Available Events\n";
					$event_comment .= $events;
					$event_comment .= "\t */";
					$contents = preg_replace('/(class.*extends.*?{)(.*\/\*\*.*Available Events.*?\*\/)?/ms', '\1'."\n\n\t".$event_comment, $contents);
					if($file->write($contents)){
						$this->out($file->name().' has been modified');
					}
				}
			}
		}
		$this->out('done');
		exit;
	}
}
