<?php
	/**
	 * This class implements the SelectCommentsMapper interface for a MySQL database.
	 */
	class MySQLSelectCommentsMapper extends MySQLMapListMapper implements SelectCommentsMapper
	{
		protected $ascending;
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->ascending = true;
			$this->criterion = new CompositeCriterion();
		}

		public function setAscending($ascending)
		{
			$this->ascending = $ascending;
		}

		public function map()
		{
			$comments = new MyList();

			$sql  = 'SELECT ';
			$sql .=   'comment.id, ';
			$sql .=   'comment.nick, ';
			$sql .=   'comment.content, ';
			$sql .=   'comment.email, ';
			$sql .=   'comment.website, ';
			$sql .=   'comment.timestamp, ';
			$sql .=   'post.id AS post_id, ';
			$sql .=   'post.title AS post_title ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('comments') . ' AS comment, ';
			$sql .=   $this->relation('posts') . ' AS post';
			$sql .=   implode('', $this->criterion->from()) . ' ';
			$sql .= 'WHERE ';
			$sql .=   'comment.post_id = post.id ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'AND ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(', ', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$sql .= 'ORDER BY ';
			$sql .=   'comment.timestamp';

			if (!$this->ascending)
				$sql .= ' DESC';

			$iterator = $this->database->query($sql);
			$iterator->skip($this->offset);

			for ($i = 0; ($this->limit == -1 || $i < $this->limit) && $iterator->hasNext(); $i ++)
			{
				$tuple = $iterator->next();

				$comment = new Map();
				$comment->put('id', $tuple['id']);
				$comment->put('nick', $tuple['nick']);
				$comment->put('content', $tuple['content']);
				$comment->put('email', $tuple['email']);
				$comment->put('website', $tuple['website']);
				$comment->put('timestamp', MySQLTimestamp::toTimestamp($tuple['timestamp']));

				$post = new Map();
				$post->put('id', $tuple['post_id']);
				$post->put('title', $tuple['post_title']);

				$comment->put('post', $post);

				$this->modifier->modify($comment);

				$comments->add($comment);
			}

			return $comments;
		}

		/**
		 * @param CommentCriterion $criterion
		 */
		public function addCriterion(CommentCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
