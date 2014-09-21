<?php

class DoubleList {

    // The head of the list.
    // @contains Node
    private $_head;
    // The tail of the list.
    // @contains Node;
    private $_tail;

    // Inserts a node at the end of the list
    // @param Node node
    // @return String
    function insertEnd($node) {

        // Base case the list is empty.
        if (!isset($this->_head)) {
            $this->_head = $node;
            $this->_tail = $node;
            return;
        }

        // Make the $node the tail.
        $node->last = $this->_tail;
        $this->_tail->next = $node;
        $this->_tail = $node;
    }

    // Inserts a node at the beginning of the list
    // @param Node node
    // @return String
    function insertBeginning($node) {
        // Base case the list is empty.
        if (!isset($this->_head)) {
            $this->_head = $node;
            $this->_tail = $node;
            return;
        }

        $node->next = $this->_head;
        $this->_head->last = $node;
        $this->_head = $node;
    }

    // Inserts a node after the given node.
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

                $node->last = $current;

                // Special case where the node is the tail.
                if (isset($current->next)) {
                    $current->next->last = $node;
                    $node->next = $current->next;
                } else {
                    $this->_tail = $node;
                }
                $current->next = $node;

                break;
            }

            $current = $current->next;
        }

        // Exception if the node wasn't added.
        if (!$flag) {
            throw new Exception("No node with the given value was found.");
        }
    }

    // Inserts a node before the given node.
    // @param Node node, Value trailValue
    // @return String
    function insertBefore($node, $trailValue) {
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
        while (isset($current->next) || $current->value == $trailValue) {
            if ($current->value == $trailValue) {

                // Check in case you're looking at the head.
                if (isset($current->last)) {
                    $node->last = $current->last;
                    $current->last->next = $node;
                } else {
                    $this->_head = $node;
                }
                $node->next = $current;
                $current->last = $node;

                break;
            }

            $current = $current->next;
        }

        // Exception if the node wasn't added.
        if (!$flag) {
            throw new Exception("No node with the given value was found.");
        }
    }

    // Checks to see if the given value is in the list.
    // @param Value value
    // @return String
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

    // Removes the first node with the given value.
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
                unset($this->_head->last);
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

        if (isset($previous->next)) {
            $previous->next->last = $previous;
        }
    }

    function __toString() {
        // Base case the list is empty.
        if (!isset($this->_head)) {
            return "";
        }

        $string = "";

        $string .= $this->_forwardString();

        // Clear the float so the second list sits on top.
        $string .= "<div style='clear:both'></div>";

        $string .= $this->_backwardString();

        return $string;
    }

    // Builds the string version of the list pointing forwards.
    private function _forwardString() {
        $string = "<div style='float:left;'><strong>Forward List:</strong></div>";

        // The node used to look forward through
        // @contains Node
        $forwards = $this->_head;

        while (isset($forwards->next)) {
            if ($forwards === $this->_head) {
                $string .= "<div class='node'>";
                $string .= $forwards->value;
                $string .= " <strong>(Head)</strong> ";
            } else {
                $string .= "<div class='node'>&#8592; ";
                $string .= $forwards->value;
            }
            $string .= " &#8594;</div>";
            $forwards = $forwards->next;
        }

        if ($forwards === $this->_head) {
            $string .= "<div class='node'>";
            $string .= $forwards->value;
            $string .= " <strong>(Head and Tail)</strong></div>";
        } else {
            $string .= "<div class='node'>&#8592; ";
            $string .= $forwards->value;
            $string .= " <strong>(Tail)</strong></div>";
        }

        return $string;
    }

    // Builds the string version of the list pointing backwards.
    private function _backwardString() {
        // Change current to the tail.
        $backwards = $this->_tail;

        // Print backwards to show double link
        $string = "<div style='float:left;'><strong>Reverse List:</strong></div>";

        while (isset($backwards->last)) {
            if ($backwards === $this->_tail) {
                $string .= "<div class='node'>";
                $string .= $backwards->value;
                $string .= " <strong>(Tail)</strong> ";
            } else {
                $string .= "<div class='node'>&#8592; ";
                $string .= $backwards->value;
            }
            $string .= " &#8594;</div>";
            $backwards = $backwards->last;
        }

        if ($backwards === $this->_tail) {
            $string .= "<div class='node'>";
            $string .= $backwards->value;
            $string .= " <strong>(Head and Tail)</strong></div>";
        } else {
            $string .= "<div class='node'>&#8592; ";
            $string .= $backwards->value;
            $string .= " <strong>(Head)</strong></div>";
        }
        return $string;
    }

}

class Node {

    // The next node.
    // @contains Node
    public $next;
    // The last node.
    // @contains Node
    public $last;
    // Value held in node.
    // @contains Anything
    public $value;

    function __construct($value) {
        $this->value = $value;
    }

}

session_save_path(getcwd() . "/sessions");
session_start();

$list = (isset($_SESSION["doubleList"]) ?
                $_SESSION["doubleList"] : new DoubleList());

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
        case "Insert Before":
            try {
                $list->insertBefore(new Node($_GET["value"]), $_GET["trailValue"]);
            } catch (Exception $e) {
                $returnString = $e;
            }
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
if (isset($_SESSION["doubleList"]) || $list !== "") {
    $_SESSION["doubleList"] = $list;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title></title>
    </head>
    <body>
        <img src="assets/doubly-linked-list.png"/><br/>
        <h1>Doubly Linked List Demo</h1>
        <div class="wrapper">
            <form method="GET" action="DoubleList.php">
                <input type="text" value="Value" name="value"><br/>
                <input type="submit" value="Insert End" name="btnAction"><br/>
                <input type="submit" value="Insert Beginning" name="btnAction"><br/>
                <input type="submit" value="Insert Before" name="btnAction">
                <input type="text" value="Trailing Value" name="trailValue"><br/>
                <input type="submit" value="Insert After" name="btnAction">
                <input type="text" value="Leading Value" name="leadValue"><br/>
                <input type="submit" value="Remove" name="btnAction"><br/>
                <input type="submit" value="Contains" name="btnAction"><br/>
                <input type="submit" value="Reset Session" name="btnAction"><br/>
            </form>
        </div><br/>
        <div class="wrapper">
            <?php
            echo $list . "</div><br/>";
            echo $returnString;
            ?>   
        </div><br/>
        <a class="button" href="index.php">Return to home</a>
    </body>
</html>