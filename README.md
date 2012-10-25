# SEO friendly url for Kohana 3.3.0 or higher

older versions you search in separate branches

## Usage

1\. Copy the directory "seo" to directory "modules" in project Kohana

2\. Add module in bootstrap:

**application/bootstrap.php**

	'seo'        => MODPATH.'seo',        // SEO friendly url

3\. Create class SEO in application/classes, where you define a connection between the key and pair controller-action and friendly url, for example:

**application/classes/seo.php**

	class SEO extends Kohana_SEO
	{
		static protected $map =
			array(
				1 => array('welcome' => array('index' => 'welcome-to-our-website')),
				2 => array('test'    => array('index' => 'test-test-test')),
			);
	}

4\. You must override the method "matches" of class Route:

**application/classes/route.php**

	class Route extends Kohana_Route
	{
		public function matches(Request $request)
		{
			$controller_action = seo::get_controller_action($request);
			
			return
				isset($controller_action)
					?   array_combine(array_keys($this->_defaults), $controller_action)
					:   parent::matches($request);
		}
	}

5\. Example in controller:

	/* without query */
	$this->template->link = HTML::anchor(SEO::friendly_url('welcome', 'index'), 'link - welcome');
	
	/* with query */
	$this->template->link = HTML::anchor(SEO::friendly_url('welcome', 'index', array('id'=>'xxx')), 'link - welcome');
	// then to get the value of the "id"
	// $id = $this->request->query('id');

6\. In view:

	<?php echo $link ?>
