<?php

class SingleList {

    // The head of the list.
    // @contains Node
    private $_head;

    // Insert a node into the end of the list.
    // @param Node node
    // @return String 
    function insertEnd($node) {
        // Base case for if the list is empty.
        if (!isset($this->_head)) {
            $this->_head = $node;
            return;
        }

        // The current node being looked at.
        // @contains Node
        $current = $this->_head;

        // Loop till you reach the end of the list.
        while (isset($current->next)) {
            $current = $current->next;
        }

        $current->next = $node;
    }

    // Insert a node at the beginning of the list
    // @param Node node
    // @return String
    function insertBeginning($node) {
        // Base case for if the list is empty.
        if (!isset($this->_head)) {
            $this->_head = $node;
            return;
        }

        // The old head.
        // @contains Node head
        $oldHead = $this->_head;

        $this->_head = $node;
        $this->_head->next = $oldHead;
    }

    // Insert a node after the first node containing the value given.
    // @param Node node, Value leadValue
    // @return String
    function insertAfter($node, $leadValue) {
        // Base case for if the list is empty.
        if (!isset($this->_head)) {
            throw new Exception("The list is empty.");
        }

        // The current node being looked at
        // @contains Node
        $current = $this->_head;

        // Flag for the node being added.
        $flag = false;

        // Loop until you hit the leading Node or the end.
        while (isset($current->next) || $current->value == $leadValue) {
            if ($current->value == $leadValue) {
                $node->next = $current->next;
                $current->next = $node;
                $flag = true;
                break;
            }
            $current = $current->next;
        }

        // Exception if the node wasn't added.
        if (!$flag) {
            throw new Exception("No node with the given value was found.");
        }
    }

    // Remove a node from the list.
    // Removes the first node found this way starting at the head.
    // @param Value value
    // @return String
    function remove($value) {
        // Base case the list is empty.
        if (!isset($this->_head)) {
            throw new Exception("The list is empty.");
        }

        // Check if the node to remove is the head.
        if ($this->_head->value == $value) {
            // Check to see if the head is the only node.
            if (isset($this->_head->next)) {
                $this->_head = $this->_head->next;
            } else {
                unset($this->_head);
            }

            return;
        }

        // The current node being looked at.
        // @contains Node
        $current = $this->_head;

        // The node previous to the current node.
        // @contains Node
        $previous = $this->_head;

        // Loop till you find the node in question
        // OR you reach the end of the list.
        while ($current->value != $value && isset($current->next)) {
            $previous = $current;
            $current = $current->next;
        }

        // If the end was reached and the last node
        // wasn't the correct node, report a failure.
        if (!isset($current->next) && ($current->value != $value)) {
            throw new Exception("No node with the given value was found.");
        }

        // Remove the reference to the current node.
        $previous->next = $current->next;
    }

    // Checks to see if the node is in the list.
    // @param Value value
    // @return String + Number of Nodes w/ the value
    function contains($value) {
        // Base case the list is empty.
        if (!isset($this->_head)) {
            return 0;
        }

        // Counter
        // @contains Int
        $counter = 0;

        // The current node.
        // @contains Node.
        $current = $this->_head;

        while (isset($current->next)) {
            if ($current->value == $value) {
                $counter++;
            }

            $current = $current->next;
        }

        if ($current->value == $value) {
            $counter++;
        }

        if ($counter > 0) {
            return $counter;
        } else {
            return 0;
        }
    }

    function __toString() {
        // Base case the list is empty.
        if (!isset($this->_head)) {
            return "";
        }

        $string = "";

        // The current node being looked at.
        // @contains Node
        $current = $this->_head;

        while (isset($current->next)) {
            $string .= "<div class='node'>";
            $string .= $current->value;
            if ($current === $this->_head) {
                $string .= " <strong>(Head)</strong> &#8594</div>";
            } else {
                $string .= " &#8594 </div>";
            }
            $current = $current->next;
        }

        $string .= "<div class='node'>";
        $string .= $current->value;
        if ($current === $this->_head) {
            $string .= " <strong>(Head)</strong></div>";
        } else {
            $string .= "</div>";
        }

        return $string;
    }

}

class Node {

    // The next node.
    // @contains Node
    public $next;
    // Value held in node.
    // @contains Anything
    public $value;

    function __construct($value) {
        $this->value = $value;
    }

}

session_save_path(getcwd() . "/sessions");
session_start();

$list = (isset($_SESSION["singleList"]) ?
                $_SESSION["singleList"] : new SingleList());

$returnString = "";

if (isset($_GET["btnAction"])) {
    $btnAction = $_GET["btnAction"];
    switch ($btnAction) {
        case "Insert End":
            $list->insertEnd(new Node($_GET["value"]));
            break;
        case "Insert Beginning":
            $list->insertBeginning(new Node($_GET["value"]));
            break;
        case "Insert After":
            try {
                $list->insertAfter(new Node($_GET["value"]), $_GET["leadValue"]);
            } catch (Exception $e) {
                $returnString = $e;
            }
            break;
        case "Remove":
            try {
                $list->remove($_GET["value"]);
            } catch (Exception $e) {
                $returnString = $e;
            }
            break;
        case "Contains":
            $returnString = "The list contains " .
                    $list->contains($_GET["value"])
                    . " nodes with that value.";
            break;
        case "Reset Session":
            session_unset();
            $list = "";
            $returnString = "Session Reset";
            break;
    }
}

if (isset($_SESSION["singleList"]) || $list !== "") {
    $_SESSION["singleList"] = $list;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Singly Linked List Demo</title>
    </head>
    <body>
        <img src="assets/singly-linked-list.png"/><br/>
        <h1>Singly Linked List Demo</h1>
        <div class="wrapper">
            <form method="GET" action="SingleList.php">
                <input type="text" value="Value" name="value"><br/>
                <input type="submit" value="Insert End" name="btnAction"><br/>
                <input type="submit" value="Insert Beginning" name="btnAction"><br/>
                <input type="submit" value="Insert After" name="btnAction">
                <input type="text" value="Leading Value" name="leadValue"><br/>
                <input type="submit" value="Remove" name="btnAction"><br/>
                <input type="submit" value="Contains" name="btnAction"><br/>
                <input type="submit" value="Reset Session" name="btnAction">
            </form>
        </div><br/>
        <div class="wrapper">
            <?php
            echo $list . "</div><br/>";
            echo $returnString;
            ?><br/>
            <a class="button" href="index.php">Return to home</a>

    </body>
</html>