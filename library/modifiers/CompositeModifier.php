<?php
	/**
	 * This class acts as a composite of several modifiers.
	 */
	class CompositeModifier implements Modifier
	{
		protected $modifiers;

		/**
		 */
		public function __construct()
		{
			$this->modifiers = array();
		}

		public function modify(Map $map)
		{
			foreach ($this->modifiers as $modifier)
				$modifier->modify($map);
		}

		public function add(Modifier $modifier)
		{
			$this->modifiers[] = $modifier;
		}
	}
