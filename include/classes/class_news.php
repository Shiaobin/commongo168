<?php
  class News {
     //Declare variables
	 private $current_news;
	 private $show_currentNews;
	 private $total_news;
	 private $totalRows_news;
	 private $total_pages;
	 private $startRow_news = 0;
	 private $maxRows_news = 4;
     private $current_page = 0;
	 private $connection;

	 //Initialize
	 function News($connection){
		$this->connection = $connection;
		$this->getNews();
	 }

	 //Get config
     function getNews() {
		 $query = "SELECT * FROM index_news WHERE set_open='1' ORDER BY set_top DESC";
		 $this->total_news = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->totalRows_news = mysql_num_rows($this->total_news);
		 $this->total_pages = ceil($this->totalRows_news/$this->maxRows_news)-1;

		 $query_limit = sprintf("%s LIMIT %d, %d", $query, $this->startRow_news, $this->maxRows_news);
         $this->current_news = mysql_query($query_limit, $this->connection) or die(mysql_error());
		 $this->show_currentNews = mysql_fetch_assoc($this->current_news);
     }

	 function getTotalNews() {
	     return $this->totalRows_news;
	 }

	 function getCurrentPage() {
	     return $this->current_page;
	 }

	 function getTotalPages() {
	     return $this->total_pages;
	 }

	 function getNewsNo() {
	     echo $this->show_currentNews["news_no"];
	 }

	 function getNewsInfo() {
	     echo $this->show_currentNews["news_info"];
	 }

	 function getNewsPop() {
	     echo $this->show_currentNews["news_pop"];
	 }

	 function getNewsDate() {
	     echo date('Y-m-d',strtotime($this->show_currentNews["news_date"]));
	 }

	 function setCurrentPage($CurrentPage) {
	     $this->current_page = $CurrentPage;
	 }

	 function fetchNews() {
	     if($this->show_currentNews = mysql_fetch_assoc($this->current_news)) return true;
		 else return false;
	 }

	 function updateNews() {
	     $this->startRow_news = $this->current_page * $this->maxRows_news;
		 $query = "SELECT * FROM index_news WHERE set_open='1' ORDER BY set_top DESC";
         $query_limit = sprintf("%s LIMIT %d, %d", $query, $this->startRow_news, $this->maxRows_news);
         $this->current_news = mysql_query($query_limit, $this->connection) or die(mysql_error());
	 }

	 function updatePage($currentPage,$next_page){
		 $this->setCurrentPage($next_page);
		 $this->updateNews($next_page);
		  printf("index.php");
	 }

	 function gotoFirstPage() {
		// $this->current_page = 0;
		 echo "hi";
	 }

	 function gotoLastPage() {
		// $this->current_page = $this->total_pages;
		 echo "hey";
	 }

	 function gotoFrontPage() {
		// $this->current_page = $this->current_page-1;
		// if($this->current_page < 0)  $this->current_page = 0;
		 echo "wow";
	 }

	 function gotoNextPage() {
		// $this->current_page = $this->current_page+1;
		// if($this->current_page > $this->total_pages)  $this->current_page = $this->total_pages;
		 echo "dfsf";
		// updateNews();
	 }
  }
?>