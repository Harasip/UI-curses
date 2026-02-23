-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 23 2026 г., 21:24
-- Версия сервера: 5.5.62
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `language_ui_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `comment_text`, `created_at`) VALUES
(4, 2, 2, '2', '2026-02-23 15:36:52');

-- --------------------------------------------------------

--
-- Структура таблицы `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `content`
--

INSERT INTO `content` (`id`, `title`, `body`, `author_id`, `created_at`, `deleted_at`) VALUES
(1, '321321', '213123123', 1, '2026-02-23 15:32:00', '2026-02-23 15:35:30'),
(2, 'Основные принципы UX/UI для приложений по изучению языков в 2025–2026 годах', 'В 2025–2026 годах пользователи онлайн-курсов по иностранным языкам ожидают от интерфейса не просто удобства, а почти «магического» ощущения прогресса и мотивации.\r\nКлючевые тренды и рекомендации:\r\n\r\nGamification 2.0\r\nНе просто очки и уровни, а «серии дней», стрики с эмоциональными напоминаниями\r\nПерсонализированные ежедневные цели, которые адаптируются под ритм пользователя\r\nАнимации с Lottie или Rive вместо простых GIF\r\n\r\nМикро-интеракции и haptic feedback (на мобильных)\r\nЛёгкая вибрация при правильном ответе\r\nПлавное появление карточек с переводом (slide-up + scale)\r\nАнимация «волны» при долгом удержании слова для добавления в избранное\r\n\r\nDark mode + OLED-оптимизация\r\nБольшинство пользователей учат язык вечером → тёмная тема должна быть идеальной\r\nИспользуйте true black (#000000) для фона на OLED-экранах, чтобы экономить заряд\r\n\r\nAdaptive spacing и fluid typography\r\nclamp() для размеров шрифтов и отступов\r\ncontainer queries для карточек словаря (чтобы они красиво перестраивались на узких экранах)\r\n\r\nVoice-first интерфейс\r\nКнопка «Говорить» всегда видна и большая\r\nВизуальная обратная связь волной при распознавании речи (Web Speech API)\r\nПоказ произношения с цветовой индикацией ошибок (зелёный — правильно, красный — акцент)\r\n\r\nAI-персонализация без перегрузки\r\nНе показывать 50 настроек — достаточно 3–4 ключевых:\r\n«Хочу говорить быстрее», «Больше грамматики», «Фокус на разговорный»\r\n\r\n\r\nПример стека 2026 года для такого приложения:\r\nNext.js 15 / React 19 + Tailwind CSS + Framer Motion + shadcn/ui + Vercel AI SDK\r\nКакой из этих пунктов кажется вам самым важным для вашего проекта?', 1, '2026-02-23 15:36:05', NULL),
(3, 'Как правильно проектировать карточки словаря в языковых приложениях (best practices 2026)', 'Карточка слова — это сердце любого приложения по изучению языков. Вот современный чек-лист 2026 года:\r\nОбязательные элементы (must-have):\r\n\r\nСлово / фраза крупно (font-weight: 600–700)\r\nТранскрипция (IPA + аудио-кнопка)\r\nПеревод (основной + 1–2 контекстных варианта)\r\nЧасть речи + род/число (цветовая индикация)\r\nПример предложения (1–2 коротких)\r\nКнопка «Добавить в избранное» (сердечко)\r\nКнопка «Повторить позже» (отложить)\r\nПрогресс повторения (spaced repetition индикатор: 1/5, 3/5 и т.д.)\r\n\r\nХорошие улучшения (nice-to-have):\r\n\r\nПереключатель «Показать перевод» (анимация flip-card)\r\nКартинка-ассоциация (автоматически через Unsplash API или DALL·E)\r\nПроизношение носителя + слоги (подсветка при прослушивании)\r\nТеги сложности (A1, B2, C1)\r\nКнопка «Сравнить произношение» (запись голоса + анализ)\r\n\r\nТехнические рекомендации:\r\n\r\nИспользовать aspect-ratio: 4/5 или 3/4 для карточек\r\nПоддержка swipe left/right (удалить / добавить в избранное)\r\nLazy-loading изображений и аудио\r\nДоступность: aria-label на все интерактивные элементы\r\nЦветовая схема: контраст минимум 4.5:1 (WCAG AA)\r\n\r\nПлохие практики, от которых стоит отказаться в 2026:\r\n\r\nПерегруженные карточки (больше 6–7 элементов)\r\nАвтоматическое озвучивание без возможности отключить\r\nОтсутствие тёмной темы\r\nФиксированная ширина карточек без адаптации\r\n\r\nКакую карточку словаря вы считаете самой удобной из существующих приложений (Duolingo, Memrise, LingQ, Anki, Busuu и т.д.) и почему?', 1, '2026-02-23 15:36:18', NULL),
(4, '432432', '43123412312', 1, '2026-02-23 18:13:52', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$rbOJ6dCcClnLZy18pvGHe.CVBY5Ri8MKIiangsKN1BaWlSToREEDO', 'admin', '2026-02-23 15:31:50'),
(2, 'a', '$2y$10$8clXhJeLVL68HNSYm4drfeLdgv0P9g6FqSkQLYMCVuAympLm6xgZy', 'user', '2026-02-23 15:32:20'),
(3, 'u', '$2y$10$n7I76dfdxYXQ0nJlSlCx3eB9y92aGSKi4GQBYbSqsM4aRouS./MJS', 'user', '2026-02-23 18:12:42');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `content` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
