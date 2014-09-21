LinkedLists
===========

Linked Lists in PHP

This project is just a simple implementation of Linked Lists using PHP, HTML, and CSS. Not generally useful due to more efficient methods of storing data being available in PHP, but is merely an excerise in learning PHP and refreshing knowledge on important data structures. 

From index.php, users can navigate to either a singly linked list or a doubly linked list using the link "buttons". Each is simply a link stylized to look like a button using CSS.

Languages
=========
The program uses PHP as its primary language, handling all of its computation. HTML is used to format all information for the user and so that it displays cleanly onto the page. CSS is used to format the site so that it looks cleaner and more 'creative'.

Singly Linked List
==================
SingleList.php consists of the implementation of a singly linked list. Broken up into 2 classes, the list and nodes, the implementation is fairly standard. Due to the short life span of PHP programs, lists are stored in sessions and are recreated each time the page is refreshed or a GET request is performed. If the user reset the session or hasn't used the site before, a new list is generated for the user. Visibly, nodes are shown as a div that floatsin the center of the screen, ass nodes are created and destroyed the nodes and list shift to make room/use the center of the screen.

Doubly Linked List
==================
