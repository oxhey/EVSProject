INSERT INTO `user_role` (`id`, `Name`, `Description`) VALUES
(1, 'Academic', 'This is a lecturer and has admin privileges'),
(2, 'Student', 'This is a student and can only take tests');

INSERT INTO `user_group` (`id`, `Name`, `Description`) VALUES
(1, 'Test Group', 'This is a test group. It could be a specific class/lecture');

INSERT INTO `user` (`id`, `Name`, `Login_ID`, `Group_ID`, `User_Role_ID`) VALUES
(1, 'Student 1', 00000001, 1, 2),
(2, 'Student 2', 00000002, 1, 2),
(3, 'Student 3', 00000003, 1, 2),
(4, 'Student 4', 00000004, 1, 2),
(5, 'Student 5', 00000005, 1, 2),
(6, 'Student 6', 00000006, 1, 2),
(7, 'Student 7', 00000008, 1, 2),
(8, 'Student 8', 00000009, 1, 2),
(9, 'Student 9', 00000010, 1, 2),
(10, 'Student 10', 00000011, 1, 2),
(11, 'Student 11', 00000012, 1, 2),
(12, 'Student 12', 00000013, 1, 2),
(13, 'Student 13', 00000014, 1, 2),
(14, 'Student 14', 00000015, 1, 2),
(15, 'Student 15', 00000016, 1, 2),
(16, 'Student 16', 00000017, 1, 2),
(17, 'Student 17', 00000018, 1, 2),
(18, 'Student 18', 00000019, 1, 2),
(19, 'Student 19', 00000020, 1, 2),
(20, 'Student 20', 00000021, 1, 2),
(21, 'Academic 1', 7001, 1, 1);

INSERT INTO `test_set` (`id`, `Name`, `Description`, `isOpen`, `Room_Code`,`Group_ID`) VALUES
(1, 'WAD Test', 'Web questions', '0', "WAD001",1),
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
(1,2,8,30),

(2,2,5,17),
(2,2,6,23),
(2,2,7,25),
(2,2,8,29),

(3,2,5,18),
(3,2,6,24),
(3,2,7,25),
(3,2,8,30),

(4,2,5,19),
(4,2,6,21),
(4,2,7,26),
(4,2,8,30),

(5,2,5,20),
(5,2,6,21),
(5,2,7,27),
(5,2,8,29),

(6,2,5,20),
(6,2,6,21),
(6,2,7,26),
(6,2,8,31),

(7,2,5,20),
(7,2,6,22),
(7,2,7,27),
(7,2,8,30),

(8,2,5,17),
(8,2,6,23),
(8,2,7,26),
(8,2,8,29),

(9,2,5,17),
(9,2,6,24),
(9,2,7,28),
(9,2,8,32),

(10,2,5,17),
(10,2,6,22),
(10,2,7,27),
(10,2,8,31),

(11,2,5,18),
(11,2,6,24),
(11,2,7,26),
(11,2,8,32),

(12,2,5,19),
(12,2,6,22),
(12,2,7,28),
(12,2,8,32),

(13,2,5,19),
(13,2,6,22),
(13,2,7,26),
(13,2,8,30),

(14,2,5,18),
(14,2,6,22),
(14,2,7,26),
(14,2,8,29),

(15,2,5,19),
(15,2,6,23),
(15,2,7,25),
(15,2,8,30),

(16,2,5,17),
(16,2,6,22),
(16,2,7,26),
(16,2,8,31),

(17,2,5,20),
(17,2,6,22),
(17,2,7,25),
(17,2,8,32),

(18,2,5,17),
(18,2,6,21),
(18,2,7,26),
(18,2,8,30),

(19,2,5,18),
(19,2,6,22),
(19,2,7,25),
(19,2,8,29);