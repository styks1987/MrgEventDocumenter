### Event Documenter Shell

This shell will parse your models and controllers to find your events and add a comment to the top of the file with all available events

### In your model or controller

The shell will look for just the first line of the below code.

So in this snippet:

~~~php5

	$event = new CakeEvent('Controller.ControllerModelName.action_you_want', $this, [
		'id'=>$this->Bid->id,
		'data'=>$this->request->data
	]);
```

It looks for:

```php5
	new CakeEvent('Controller.ControllerModelName.action_you_want',
```

You can also add a comment directy above that line and it will add that next to the comment at the top of the file

```php5
	// This is my event and here is why I call it
	new CakeEvent('Controller.ControllerModelName.action_you_want',
```

In the top of this file that this is found in, it will place the following

```php5
	class MyController extends AppController {

		/**
		 * Available Events
		 * Controller.MyController.action_you_want - This is my event and here is why I call it
		 */
```


If you add events later, it will replace the current comment with an updated comment

### Runing the Shell

Sorry for the long name but here is how you run this from the command line
Make sure you are in your app directory or put the absolute path to your app as an option

```
	$cake MrgEventDocumenter.EventDocumenter document
```

### TODO

Lots left to do, these are the most obvious to me

1. Generate a master event list file
1. Specify where that file gets saved
1. Refine Regex
