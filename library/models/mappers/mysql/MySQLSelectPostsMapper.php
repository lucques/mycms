<?php
	/**
	 * This class implements the SelectPostsMapper interface for a MySQL database.
	 */
	class MySQLSelectPostsMapper extends MySQLMapListMapper implements SelectPostsMapper
	{
		protected $ascending;
		protected $selectAuthor;
		protected $selectCategories;
		protected $authorModifier;
		protected $categoryModifier;
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->ascending = true;
			$this->selectAuthor = false;
			$this->selectCategories = false;
			$this->authorModifier = new CompositeModifier();
			$this->categoryModifier = new CompositeModifier();
			$this->criterion = new CompositeCriterion();
		}

		public function setAscending($ascending)
		{
			$this->ascending = $ascending;
		}

		public function setSelectAuthor($selectAuthor)
		{
			$this->selectAuthor = $selectAuthor;
		}

		public function setSelectCategories($selectCategories)
		{
			$this->selectCategories = $selectCategories;
		}

		public function addAuthorModifier(Modifier $modifier)
		{
			$this->authorModifier->add($modifier);
		}

		public function addCategoryModifier(Modifier $modifier)
		{
			$this->categoryModifier->add($modifier);
		}

		public function map()
		{
			$posts = new MyList();

			if ($this->selectAuthor)
			{
				$criterion = new ModifiableCriterion();
				$criterion->addToFrom(', ' . $this->relation('users') . ' AS author');
				$criterion->addToWhere('post.author_id = author.id');

				$this->criterion->add($criterion);
			}

			$sql  = 'SELECT ';
			$sql .=   'post.id, ';
			$sql .=   'post.title, ';
			$sql .=   'post.content, ';
			$sql .=   'post.show_comments, ';
			$sql .=   'post.allow_comments, ';
			$sql .=   'post.show_link, ';
			$sql .=   'post.show_timestamp, ';
			$sql .=   'post.show_author, ';
			$sql .=   'post.is_static, ';
			$sql .=   'post.timestamp';

			if ($this->selectAuthor)
			{
				$sql .= ', author.id AS author_id, ';
				$sql .=   'author.nick AS author_nick, ';
				$sql .=   'author.website AS author_website';
			}

			$sql .=   ' ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('posts') . ' AS post';
			$sql .=   implode('', $this->criterion->from()) . ' ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'WHERE ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(', ', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$sql .= 'ORDER BY ';
			$sql .=   'post.timestamp';

			if (!$this->ascending)
				$sql .= ' DESC';

			$sql .= ', post.title, ';
			$sql .=   'post.id ';

			$iterator = $this->database->query($sql);
			$iterator->skip($this->offset);

			$ids = array();

			for ($i = 0; ($this->limit == -1 || $i < $this->limit) && $iterator->hasNext(); $i ++)
			{
				$tuple = $iterator->next();

				$post = new Map();
				$post->put('id', $tuple['id']);
				$post->put('title', $tuple['title']);
				$post->put('content', $tuple['content']);
				$post->put('showComments', $tuple['show_comments']);
				$post->put('allowComments', $tuple['allow_comments']);
				$post->put('showLink', $tuple['show_link']);
				$post->put('showTimestamp', $tuple['show_timestamp']);
				$post->put('showAuthor', $tuple['show_author']);
				$post->put('isStatic', $tuple['is_static']);
				$post->put('timestamp', MySQLTimestamp::toTimestamp($tuple['timestamp']));

				if ($this->selectAuthor)
				{
					$author = new Map();
					$author->put('id', $tuple['author_id']);
					$author->put('nick', $tuple['author_nick']);
					$author->put('website', $tuple['author_website']);

					$this->authorModifier->modify($author);

					$post->put('author', $author);
				}

				if (!$this->selectCategories)
					$this->modifier->modify($post);

				$posts->add($post);

				$ids[] = $post->get('id');
			}

			if ($posts->size() > 0 && $this->selectCategories)
			{
				$sql  = 'SELECT ';
				$sql .=   'category.id, ';
				$sql .=   'category.title, ';
				$sql .=   'post.id AS post_id, ';
				$sql .=   'post.timestamp AS post_timestamp, ';
				$sql .=   'post.title AS post_title ';
				$sql .= 'FROM ';
				$sql .=   $this->relation('categories') . ' AS category, ';
				$sql .=   $this->relation('posts') . ' AS post, ';
				$sql .=   $this->relation('posts2categories') . ' AS post2category ';
				$sql .= 'WHERE ';
				$sql .=   'post2category.category_id = category.id AND ';
				$sql .=   'post2category.post_id = post.id AND ';
				$sql .=   'post.id IN ("' . implode('", "', $ids) . '") ';
				$sql .= 'ORDER BY ';
				$sql .=   'post_timestamp';

				if (!$this->ascending)
					$sql .= ' DESC';

				$sql .= ', post_title, ';
				$sql .=   'post_id, ';
				$sql .=   'category.title, ';
				$sql .=   'category.id';

				$resultIterator = $this->database->query($sql);
				$postIterator = $posts->iterator();

				$swapCategory = null;
				$swapPostId = '';

				while ($postIterator->hasNext())
				{
					$post = $postIterator->next();
					$post->put('categories', new MyList());

					if ($swapCategory != null && $post->get('id') == $swapPostId)
					{
						$post->get('categories')->add($swapCategory);

						$swapCategory = null;
					}

					if ($swapCategory == null)
						while ($resultIterator->hasNext())
						{
							$tuple = $resultIterator->next();

							$category = new Map();
							$category->put('id', $tuple['id']);
							$category->put('title', $tuple['title']);

							$this->categoryModifier->modify($category);

							if ($post->get('id') == $tuple['post_id'])
								$post->get('categories')->add($category);
							else
							{
								$swapCategory = $category;
								$swapPostId = $tuple['post_id'];

								break;
							}
						}

					$this->modifier->modify($post);
				}
			}

			return $posts;
		}

		/**
		 * @param PostCriterion $criterion
		 */
		public function addCriterion(PostCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
