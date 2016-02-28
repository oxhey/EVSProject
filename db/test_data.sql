INSERT INTO `user_role` (`id`, `Name`, `Description`) VALUES
(1, 'Academic', 'This is a lecturer and has admin privlages'),
(2, 'Student', 'This is a student and can only take tests');

INSERT INTO `user_group` (`id`, `Name`, `Description`) VALUES
(1, 'Test Group', 'This is a test group. It could be a specific class/lecture');

INSERT INTO `user` (`id`, `Name`, `Login_ID`, `Group_ID`, `User_Role_ID`) VALUES
(1, 'Student 1', 14083313, 1, 2),
(2, 'Student 2', 14083314, 1, 2),
(3, 'Academic 1', 7045, 1, 1);

INSERT INTO `test_set` (`id`, `Name`, `Description`, `isOpen`, `Room_Code`,`Group_ID`) VALUES
(1, 'WAD Test', 'Web questions for a web course', '0', "WAD001",1),
(2, 'Java Test', 'Java questions', '0', "JAVA01",1);

INSERT INTO `question` (`id`, `Test_ID`, `QText`) VALUES
(1, 1, 'A webpage displays a picture. What tag was used to display that picture?'),
(2, 1, 'How can you make a numbered list?'),
(3, 1, 'To create HTML document you require a ...'),
(4, 1, 'Which of the following HTML code is valid?'),

(5, 2, 'Java programs are?'),
(6, 2, 'The command javac is used to?'),
(7, 2, 'Which of the following is not the java primitive type?'),
(8, 2, 'What will be the output of the following code?
    byte x=64, y;
    y= (byte) (x<<2);
    System.out.println(y);');

INSERT INTO `answer` (`id`, `Question_ID`, `AText`) VALUES
(1, 1, '&lt;picture&gt;'),
(2, 1, '&lt;image&gt;'),
(3, 1, '&lt;img&gt;'),
(4, 1, '&lt;src&gt;'),

(5, 2, '&lt;dl&gt;'),
(6, 2, '&lt;ol&gt;'),
(7, 2, '&lt;list&gt;'),
(8, 2, '&lt;ul&gt;'),

(9, 3, 'web page editing software'),
(10, 3, 'High powered computer'),
(11, 3, 'Just a notepad can be used'),
(12, 3, 'None of above'),

(13, 4, '&lt;font colour=&quot;red&quot;&gt;'),
(14, 4, '&lt;font color=&quot;red&quot;&gt;'),
(15, 4, '&lt;red&gt;&lt;font&gt;'),
(16, 4, 'All of above are style tags'),

(17, 5, 'Faster than others'),
(18, 5, 'Platform independent'),
(19, 5, 'Not reusable'),
(20, 5, 'Not scalable'),

(21, 6, 'debug a java program'),
(22, 6, 'compile a java program'),
(23, 6, 'interpret a java program'),
(24, 6, 'execute a java program'),

(25, 7, 'Byte'),
(26, 7, 'Float'),
(27, 7, 'Character'),
(28, 7, 'Long double'),

(29, 8, '0'),
(30, 8, '1'),
(31, 8, '2'),
(32, 8, '64');

INSERT INTO `correct_answer` (`id`, `Question_ID`, `Answer_ID`) VALUES
(1, 1, 3),
(2, 2, 6),
(3, 3, 11),
(4, 4, 14),
(5, 5, 18),
(6, 6, 22),
(7, 7, 28),
(8, 8, 29);

INSERT INTO `evs`.`user_answers` (`User_ID`,`Test_ID`,`Question_ID`,`Answer_ID`) VALUES
(1,2,5,18),
(1,2,6,22),
(1,2,7,26),
(1,2,8,30);